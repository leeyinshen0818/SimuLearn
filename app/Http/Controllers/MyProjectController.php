<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MyProjectController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Get all enrolled projects
        $enrolledProjects = $user->projects()
            ->withPivot('status', 'progress')
            ->get();

        // Determine the active project
        $activeProjectId = $request->query('project_id');
        $activeProject = null;
        $currentTask = null;

        if ($enrolledProjects->isNotEmpty()) {
            if ($activeProjectId) {
                $activeProject = $enrolledProjects->firstWhere('id', $activeProjectId);
            } else {
                $activeProject = $enrolledProjects->firstWhere('pivot.status', 'in_progress') ?? $enrolledProjects->first();
            }
        }

        if ($activeProject) {
            // Load tasks for the active project
            $activeProject->load(['tasks.userTasks' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }]);

            // Determine the current task (first non-completed task, or the last one if all completed)
            $currentTask = $activeProject->tasks->first(function ($task) {
                $userTask = $task->userTasks->first();
                return !$userTask || $userTask->status !== 'completed';
            });

            // If no current task found (all completed?), maybe show the last one or a summary
            if (!$currentTask) {
                $currentTask = $activeProject->tasks->last();
            }

            // Load specific details for the current task view
            if ($currentTask) {
                 $currentTask->load('skills');
            }
        }

        return Inertia::render('MyProject/Index', [
            'enrolledProjects' => $enrolledProjects,
            'activeProject' => $activeProject,
            'currentTask' => $currentTask,
        ]);
    }

    public function store(Request $request, Project $project)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Check if already enrolled
        if (!$user->projects()->where('projects.id', $project->id)->exists()) {
            // Attach project
            $user->projects()->attach($project->id, [
                'status' => 'in_progress',
                'progress' => 0,
                'started_at' => now(),
            ]);

            // Initialize user tasks
            $project->load('tasks.prerequisites');
            foreach ($project->tasks as $task) {
                 $hasPrerequisites = $task->prerequisites->isNotEmpty();
                 $user->tasks()->create([
                     'task_id' => $task->id,
                     'status' => $hasPrerequisites ? 'locked' : 'unlocked'
                 ]);
            }
        }

        return redirect()->route('my-projects.index', ['project_id' => $project->id]);
    }

    public function destroy(Project $project)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Detach project
        $user->projects()->detach($project->id);

        // Delete user tasks associated with this project
        $taskIds = $project->tasks()->pluck('id');
        $user->tasks()->whereIn('task_id', $taskIds)->delete();

        return redirect()->route('my-projects.index');
    }
}
