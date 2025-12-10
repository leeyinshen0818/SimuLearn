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
    protected $ignoredDirectories = ['node_modules', 'vendor', '.git', 'storage', 'dist', 'build'];

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

            if (empty($codeContent)) {
                throw new \Exception("No valid source code files found in the submission.");
            }

            // 4. Prepare AI Prompt
            $task = $submission->userTask->task;
            $prompt = $this->constructPrompt($task, $codeContent);

            // 5. Call AI (DISABLED FOR DEVELOPMENT)
            /*
            $apiKey = env('GEMINI_API_KEY');
            if (!$apiKey) {
                throw new \Exception("GEMINI_API_KEY is not configured.");
            }

            // Using gemini-pro for maximum compatibility and stability
            $response = Http::retry(3, 2000)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->failed()) {
                Log::error("Gemini API Error: " . $response->body());
                throw new \Exception("AI Grading failed: " . $response->status());
            }

            $responseData = $response->json();
            $aiText = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '';

            // Extract JSON using regex to handle potential markdown or preamble
            if (preg_match('/\{[\s\S]*\}/', $aiText, $matches)) {
                $jsonString = $matches[0];
            } else {
                $jsonString = $aiText;
            }

            $result = json_decode($jsonString, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                // Fallback if JSON parsing fails
                Log::warning("AI Grading JSON Parse Error. Raw output: " . $aiText);
                $score = 70; // Default fallback
                $feedback = $aiText; // Use the raw text as feedback if it's not JSON
            } else {
                $score = $result['score'] ?? 0;
                $feedback = $result['feedback'] ?? "No feedback provided.";
            }
            */

            // MOCK RESULT
            $score = 85;
            $feedback = "AI Grading is temporarily disabled for development.\n\n**Mock Feedback:**\n- The submission was received successfully.\n- Code structure appears valid.\n- This is a placeholder result to allow workflow testing.";

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
            // 7. Cleanup
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

        foreach ($files as $file) {
            $relativePath = str_replace($directory, '', $file->getPathname());

            // Skip ignored directories
            foreach ($this->ignoredDirectories as $ignored) {
                // Check against relative path to avoid matching the system storage path
                if (str_contains($relativePath, DIRECTORY_SEPARATOR . $ignored . DIRECTORY_SEPARATOR) ||
                    str_starts_with(ltrim($relativePath, DIRECTORY_SEPARATOR), $ignored . DIRECTORY_SEPARATOR)) {
                    $debugLog[] = "Skipped (Ignored Dir): $relativePath";
                    continue 2;
                }
            }

            // Check extension
            if (in_array($file->getExtension(), $this->allowedExtensions)) {
                $fileContent = file_get_contents($file->getPathname());

                // Limit file size to avoid token overflow (e.g., 10KB per file)
                if (strlen($fileContent) > 10000) {
                    $fileContent = substr($fileContent, 0, 10000) . "\n...[Truncated]...";
                }

                $content .= "\n\n--- FILE: " . $relativePath . " ---\n";
                $content .= $fileContent;
                $debugLog[] = "Included: $relativePath";
            } else {
                $debugLog[] = "Skipped (Extension " . $file->getExtension() . "): $relativePath";
            }
        }

        if (empty($content)) {
            // If no content found, throw exception with debug info
            $debugString = implode("\n", $debugLog);
            throw new \Exception("No valid source code files found in the submission.\nScanned Files:\n" . $debugString);
        }

        return $content;
    }

    protected function constructPrompt($task, $codeContent)
    {
        return "You are a Senior Technical Lead reviewing a junior developer's code.\n\n" .
               "TASK TITLE: " . $task->title . "\n" .
               "SCENARIO: " . $task->scenario . "\n" .
               "EXPECTED OUTCOME: " . $task->expected_outcome . "\n\n" .
               "SCORING RUBRIC:\n" .
               "- 90-100 (Excellent): Meets all requirements, follows best practices, clean code, no errors.\n" .
               "- 75-89 (Good): Functional, meets core requirements, but has minor code quality issues or inefficiencies.\n" .
               "- 60-74 (Satisfactory): Functional but misses some edge cases or has poor structure/formatting.\n" .
               "- < 60 (Needs Improvement): Does not meet the core expected outcome or has critical bugs.\n\n" .
               "Please review the following code submission and provide:\n" .
               "1. A score from 0-100 based on the rubric.\n" .
               "2. Constructive feedback on correctness, code quality, and best practices.\n\n" .
               "IMPORTANT: Return ONLY a valid JSON object with the following structure:\n" .
               "{ \"score\": number, \"feedback\": \"string\" }\n\n" .
               "SUBMITTED CODE:\n" .
               $codeContent;
    }
}
