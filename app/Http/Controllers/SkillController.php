<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class SkillController extends Controller
{
    public function create()
    {
        $skills = Skill::all()->groupBy('category');
        /** @var User $user */
        $user = auth()->user();
        $userSkills = $user->skills()->get()->map(function ($skill) {
            return [
                'id' => $skill->id,
            ];
        });

        return Inertia::render('Profile/SkillProfile', [
            'skills' => $skills,
            'userSkills' => $userSkills,
            'userBio' => $user->bio,
            'userBioSummary' => $user->bio_summary,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'skills' => 'array',
            'skills.*' => 'exists:skills,id',
            'bio' => 'nullable|string|max:5000',
        ]);

        /** @var User $user */
        $user = auth()->user();
        $selectedSkillIds = $request->skills ?? [];
        $bio = $request->bio;

        // Auto-detect skills from bio
        if ($bio) {
            $allSkills = Skill::all();
            foreach ($allSkills as $skill) {
                // Simple case-insensitive check first
                if (stripos($bio, $skill->name) !== false) {
                    // If found, do a more strict check to avoid partial matches (e.g. "Java" in "JavaScript")
                    // For skills with symbols (C++, .NET), word boundaries \b might fail.
                    // We'll use a custom boundary check or just accept the simple match for now if it's complex.

                    // Improved regex that handles symbols better:
                    // Look for the skill name surrounded by non-word characters OR start/end of string.
                    // But we treat the skill name as a literal block.
                    $quotedName = preg_quote($skill->name, '/');

                    // If the skill name contains non-word characters (like C++, .NET), we shouldn't use \b around those sides.
                    // This is getting complicated. Let's stick to a simpler approach:
                    // If the skill name is found and it's surrounded by whitespace or punctuation.

                    $pattern = '/(?<=^|[\s\.,;:\(\)\[\]])' . $quotedName . '(?=$|[\s\.,;:\(\)\[\]])/i';

                    if (preg_match($pattern, $bio)) {
                        if (!in_array($skill->id, $selectedSkillIds)) {
                            $selectedSkillIds[] = $skill->id;
                        }
                    }
                }
            }
        }

        $bioSummary = null;

        Log::info('SkillController: Processing profile update. Bio provided: ' . ($bio ? 'Yes' : 'No'));
        Log::info('Gemini Key configured: ' . (env('GEMINI_API_KEY') ? 'Yes' : 'No'));

        // Try Gemini first if key exists
        if ((!empty($selectedSkillIds) || $bio) && env('GEMINI_API_KEY')) {
            try {
                $apiKey = env('GEMINI_API_KEY');
                Log::info('SkillController: Calling Gemini API for Analysis');

                // Get skill names
                $skillNames = Skill::whereIn('id', $selectedSkillIds)->pluck('name')->toArray();
                $skillsString = implode(', ', $skillNames);

                $prompt = "You are a technical career analyst. Analyze the following developer profile:\n\n";
                $prompt .= "Skills: " . $skillsString . "\n";
                if ($bio) {
                    $prompt .= "Bio: " . $bio . "\n";
                }
                $prompt .= "\nBased on this, list 3-5 key technical capabilities and potential roles for this developer. Format the output as a concise bulleted list (using •). Do not include introductory text.";

                $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]);

                Log::info('Gemini API Response Status: ' . $response->status());

                if ($response->successful()) {
                    // Gemini response structure: candidates[0].content.parts[0].text
                    $bioSummary = $response->json('candidates.0.content.parts.0.text');
                    Log::info('Gemini Summary generated successfully');
                } else {
                    Log::error('Gemini API Error: ' . $response->body());
                }
            } catch (\Exception $e) {
                Log::error('Gemini Exception: ' . $e->getMessage());
            }
        }
        // Fallback to OpenAI if Gemini is not configured but OpenAI is
        else if ($bio && env('OPENAI_API_KEY')) {
            try {
                $response = Http::withToken(env('OPENAI_API_KEY'))
                    ->post('https://api.openai.com/v1/chat/completions', [
                        'model' => 'gpt-3.5-turbo',
                        'messages' => [
                            ['role' => 'system', 'content' => 'You are a professional career consultant. Summarize the following professional bio into a concise, formal summary suitable for a developer profile (max 3 sentences).'],
                            ['role' => 'user', 'content' => $bio],
                        ],
                        'max_tokens' => 150,
                    ]);

                if ($response->successful()) {
                    $bioSummary = $response->json('choices.0.message.content');
                } else {
                    Log::error('OpenAI API Error: ' . $response->body());
                }
            } catch (\Exception $e) {
                Log::error('OpenAI Exception: ' . $e->getMessage());
            }
        }

        $user->skills()->sync($selectedSkillIds);
        $user->update([
            'bio' => $bio,
            'bio_summary' => $bioSummary ?? $user->bio_summary // Keep old summary if new one fails or bio is empty
        ]);

        return redirect()->route('profile.skills')->with('success', 'Skill profile updated successfully!');
    }
}
