<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Services\GradingService;

class SubmissionController extends Controller
{
    public function store(Request $request, $taskId, GradingService $grader)
    {
        $request->validate([
            'file' => 'required|file|mimes:zip|max:20480', // Max 20MB
        ]);

        $user = Auth::user();

        // Find the UserTask
        $userTask = UserTask::where('user_id', $user->id)
            ->where('task_id', $taskId)
            ->firstOrFail();

        // Handle File Upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Store in storage/app/submissions/{user_id}/{task_id}/
            $path = $file->storeAs("submissions/{$user->id}/{$taskId}", $fileName);

            // Create Submission Record
            $submission = Submission::create([
                'user_task_id' => $userTask->id,
                'file_path' => $path,
                'file_name' => $fileName,
                'attempt_number' => $userTask->submissions()->count() + 1,
                'status' => 'pending',
            ]);

            // Trigger Grading Immediately
            try {
                $result = $grader->grade($submission);

                // If score is passing (>= 60), mark task as completed
                if ($result['score'] >= 60) {
                    $userTask->update([
                        'status' => 'completed',
                        'completed_at' => now(),
                    ]);
                    return back()->with('success', "Solution graded! Score: {$result['score']}. Task Completed!");
                } else {
                    return back()->with('warning', "Solution graded. Score: {$result['score']}. Please review feedback and try again.");
                }

            } catch (\Exception $e) {
                // If grading fails, keep it as pending
                return back()->with('success', 'Solution submitted! Grading is processing in background.');
            }
        }

        return back()->with('error', 'File upload failed.');
    }

    public function destroy(Submission $submission)
    {
        if ($submission->userTask->user_id !== Auth::id()) {
            abort(403);
        }

        if ($submission->status !== 'pending') {
            return back()->with('error', 'Cannot remove a submission that has already been graded.');
        }

        // Delete file
        if (Storage::exists($submission->file_path)) {
            Storage::delete($submission->file_path);
        }

        $submission->delete();

        return back()->with('success', 'Submission removed successfully.');
    }
}
