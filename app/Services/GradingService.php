<?php

namespace App\Services;

use App\Models\Submission;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GradingService
{
    protected $allowedExtensions = ['php', 'js', 'jsx', 'ts', 'tsx', 'css', 'html', 'sql', 'json', 'md'];
    protected $ignoredDirectories = ['node_modules', 'vendor', '.git', 'storage', 'dist', 'build', 'public', 'tests', 'lang'];

    public function grade(Submission $submission)
    {
        // 1. Validate File Exists
        $zipPath = Storage::path($submission->file_path);
        if (!file_exists($zipPath)) {
            throw new \Exception("Submission file not found at: " . $zipPath);
        }

        // 2. Extract ZIP to Temporary Directory
        $extractPath = storage_path('app/temp/grading/' . $submission->id . '_' . time());
        $this->extractZip($zipPath, $extractPath);

        try {
            // 3. Read and Aggregate Code
            $codeContent = $this->readProjectFiles($extractPath);

            // 4. Prepare AI Prompt
            $task = $submission->userTask->task;
            $prompt = $this->constructPrompt($task, $codeContent);

            // 5. Call AI (Groq API - Llama 3.3 70B)
            $apiKey = env('GROQ_API_KEY');
            if (!$apiKey) {
                Log::warning("GROQ_API_KEY missing. Falling back to Mock.");
                $score = 85;
                $feedback = "SimuLearn Grading (Mock Mode):\nScore: 85/100\n\nNote: Configure GROQ_API_KEY for real AI grading.";
            } else {

                Log::info("GradingService: Sending payload to Groq (Llama 3.3). Length: " . strlen($prompt) . " chars.");

                // Using Groq's OpenAI-compatible endpoint
                $response = Http::retry(3, 2000)
                    ->withHeaders([
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $apiKey
                    ])
                    ->post("https://api.groq.com/openai/v1/chat/completions", [
                        'model' => 'llama-3.3-70b-versatile',
                        'messages' => [
                            [
                                'role' => 'system',
                                'content' => "You are an expert Senior Technical Lead. You are strictly grading a coding submission.\n" .
                                    "You MUST return the result in valid JSON format only."
                            ],
                            [
                                'role' => 'user',
                                'content' => $prompt
                            ]
                        ],
                        'temperature' => 0.1, // Low temp for consistency
                        'response_format' => ['type' => 'json_object'] // Force JSON mode
                    ]);

                if ($response->failed()) {
                    Log::error("Groq API Error: " . $response->body());
                    if ($response->status() === 429) {
                        // Graceful Fallback for Groq Limit
                        $score = 80;
                        $feedback = "# Grading Report (Fallback)\n\n";
                        $feedback .= "**System Warning**: The Groq AI Service is currently rate-limited (429).\n";
                        $feedback .= "Showing a simulated passing grade.\n";
                    } else {
                        throw new \Exception("AI Grading failed: " . $response->status());
                    }
                } else {
                    $responseData = $response->json();
                    $aiText = $responseData['choices'][0]['message']['content'] ?? '';

                    // Parse the structured JSON
                    $result = json_decode($aiText, true);

                    if (json_last_error() !== JSON_ERROR_NONE) {
                        Log::error("AI Grading JSON Parse Error. Raw: " . $aiText);
                        $score = 70;
                        $feedback = "Error parsing AI response. Raw output:\n" . $aiText;
                    } else {
                        $score = $result['score'] ?? 0;
                        $feedback = "# Grading Report\n\n";
                        $feedback .= "**Summary**: " . ($result['summary'] ?? 'No summary provided.') . "\n\n";
                        $feedback .= "## 🐛 Bugs Detected\n";
                        if (!empty($result['bugs'])) {
                            foreach ($result['bugs'] as $bug) {
                                $feedback .= "- " . $bug . "\n";
                            }
                        } else {
                            $feedback .= "No critical bugs found.\n";
                        }
                        $feedback .= "\n## 🛠 Suggested Fixes\n";
                        if (!empty($result['fixes'])) {
                            foreach ($result['fixes'] as $fix) {
                                $feedback .= "- " . $fix . "\n";
                            }
                        } else {
                            $feedback .= "No specific fixes suggested.\n";
                        }
                    }
                }
            }

            // 6. Update Submission
            $submission->update([
                'score' => $score,
                'feedback' => $feedback,
                'status' => 'graded'
            ]);

            return [
                'score' => $score,
                'feedback' => $feedback
            ];

        } finally {
            File::deleteDirectory($extractPath);
        }
    }

    protected function extractZip($zipPath, $extractPath)
    {
        $zip = new ZipArchive;
        if ($zip->open($zipPath) === TRUE) {
            $zip->extractTo($extractPath);
            $zip->close();
        } else {
            throw new \Exception("Failed to open ZIP file.");
        }
    }

    protected function readProjectFiles($directory)
    {
        $content = "";
        $files = File::allFiles($directory);
        $debugLog = [];

        $totalLength = 0;
        $maxLength = 32000;

        foreach ($files as $file) {
            if ($totalLength >= $maxLength) {
                $content .= "\n\n[SYSTEM WARNING]: Remaining files truncated due to API context limits.";
                break;
            }

            $relativePath = str_replace($directory, '', $file->getPathname());

            foreach ($this->ignoredDirectories as $ignored) {
                if (
                    str_contains($relativePath, DIRECTORY_SEPARATOR . $ignored . DIRECTORY_SEPARATOR) ||
                    str_starts_with(ltrim($relativePath, DIRECTORY_SEPARATOR), $ignored . DIRECTORY_SEPARATOR)
                ) {
                    $debugLog[] = "Skipped (Ignored Dir): $relativePath";
                    continue 2;
                }
            }

            if (in_array($file->getExtension(), $this->allowedExtensions)) {
                $fileContent = file_get_contents($file->getPathname());
                $perFileLimit = 4000;

                if (strlen($fileContent) > $perFileLimit) {
                    $fileContent = substr($fileContent, 0, $perFileLimit) . "\n...[File Truncated]...";
                }

                $fileEntry = "\n\n--- FILE: " . $relativePath . " ---\n" . $fileContent;

                if (($totalLength + strlen($fileEntry)) > $maxLength) {
                    $remainingBudget = $maxLength - $totalLength;
                    if ($remainingBudget > 100) {
                        $content .= substr($fileEntry, 0, $remainingBudget) . "\n...[Global Truncation]...";
                        $totalLength += $remainingBudget;
                    }
                    $content .= "\n\n[SYSTEM WARNING]: Context limit reached.";
                    break;
                }

                $content .= $fileEntry;
                $totalLength += strlen($fileEntry);
                $debugLog[] = "Included: $relativePath";
            } else {
                $debugLog[] = "Skipped (Extension " . $file->getExtension() . "): $relativePath";
            }
        }

        if (empty($content)) {
            $debugString = implode("\n", $debugLog);
            throw new \Exception("No valid source code files found in the submission.\nScanned Files:\n" . $debugString);
        }

        return $content;
    }

    protected function constructPrompt($task, $codeContent)
    {
        return "TASK TITLE: " . $task->title . "\n" .
            "SCENARIO: " . $task->scenario . "\n" .
            "EXPECTED OUTCOME: " . $task->expected_outcome . "\n\n" .
            "ROLE: You are a Lead Code Reviewer known for being strict, precise, and anti-fluff. You hate generic feedback.\n\n" .
            "STRICT REVIEW RULES (FOLLOW THESE OR FAIL):\n" .
            "1. NO HALLUCINATIONS: Do NOT complain about missing features (like 'missing alt tags') unless an <img> tag actually exists in the code. IF IT IS NOT THERE, DO NOT INVENT IT.\n" .
            "2. CONTEXT AWARE: If the user is using a CDN (e.g., Tailwind Play CDN) in a simple HTML file, do NOT complain about 'performance' or suggest a build step. Accept the context of a simple simulation.\n" .
            "3. EVIDENCE REQUIRED: For every bug you list, you must vaguely reference the specific line or section. Do not say 'the code is messy'—say 'The header indentation is inconsistent'.\n" .
            "4. NO GENERIC PRAISE: Do not say 'good job' or 'well structured' unless it is truly exceptional. Focus on technical correctness.\n" .
            "5. SYNTAX & LOGIC FIRST: Prioritize broken code, bad variable names, and security risks over minor styling preferences.\n\n" .
            "SCORING RUBRIC:\n" .
            "- 90-100: Flawless. No logical errors, perfect conventions.\n" .
            "- 75-89: Good. Works, but has minor bad practices (e.g., magic numbers, poor naming).\n" .
            "- 50-74: Weak. Works but is fragile, messy, or violates the core task instructions.\n" .
            "- < 50: Fail. Does not run or misses the main objective completely.\n\n" .
            "OUTPUT FORMAT:\n" .
            "Return ONLY a raw JSON object (no markdown formatting) with this exact schema:\n" .
            "{\n" .
            "  \"score\": number (0-100),\n" .
            "  \"summary\": \"Direct assessment of the submission quality.\",\n" .
            "  \"bugs\": [ \"[Critical] List specific issue\", \"[Minor] List specific issue\" ],\n" .
            "  \"fixes\": [ \"Specific code change to fix the corresponding bug\" ]\n" .
            "}\n\n" .
            "SUBMITTED CODE:\n" .
            $codeContent;
    }
}
