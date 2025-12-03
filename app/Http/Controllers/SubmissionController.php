<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function store(Request $request, $taskId)
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

            // We do NOT mark the task as completed yet.
            // It remains in its current status (e.g. 'unlocked') until graded.

            return back()->with('success', 'Solution submitted successfully! It is now pending review.');
        }

        return back()->with('error', 'File upload failed.');
    }
}
