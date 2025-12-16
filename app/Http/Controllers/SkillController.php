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
        Log::info('AI calls disabled: using mock bio summary');

        // AI temporarily disabled: always use mock summary to avoid token usage
        if (!empty($selectedSkillIds) || $bio) {
            $bioSummary = "• Full Stack Development capabilities\n• Strong proficiency in PHP and JavaScript\n• Experience with Laravel and React ecosystems\n• Potential roles: Full Stack Developer, Backend Engineer\n• AI summarization currently mocked (Gemini disabled)";
        }

        $user->skills()->sync($selectedSkillIds);
        $user->update([
            'bio' => $bio,
            'bio_summary' => $bioSummary ?? $user->bio_summary // Keep old summary if new one fails or bio is empty
        ]);

        return redirect()->route('profile.skills')->with('success', 'Skill profile updated successfully!');
    }
}
