<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
                $query->where('user_id', $user->id)->with('submissions');
            }, 'tasks.skills', 'tasks.prerequisites']);

            // Filter tasks: Show Completed OR (Prerequisites Met AND Skills Match)
            $userSkills = $user->skills()->pluck('skills.id')->toArray();

            $filteredTasks = $activeProject->tasks->filter(function ($task) use ($userSkills) {
                $userTask = $task->userTasks->first();
                $isCompleted = $userTask && $userTask->status === 'completed';

                if ($isCompleted) {
                    return true;
                }

                // Check prerequisites
                $prereqsMet = $task->prerequisites->every(function ($prereq) use ($task) {
                    // We need to check if the prerequisite is completed.
                    // Since we are iterating the collection, we can't easily check the *other* task's userTask without loading it.
                    // Fortunately, we loaded 'tasks.userTasks' for the whole project, but $task->prerequisites is a relation.
                    // We need to check the user_tasks table or the loaded relation on the prerequisite if it was loaded recursively?
                    // No, 'tasks.prerequisites' loads the Task models for prerequisites. It DOES NOT automatically load their userTasks.

                    // However, we can check the 'user_tasks' table directly or use the collection if we map IDs.
                    // Let's use a simpler approach: Get all completed task IDs first.
                    return true;
                });

                return true;
            });

            // Re-implementing filter with prepared data
            $allTasks = $activeProject->tasks;
            $completedTaskIds = $allTasks->filter(function ($t) {
                $ut = $t->userTasks->first();
                return $ut && $ut->status === 'completed';
            })->pluck('id')->toArray();

            $filteredTasks = $allTasks->filter(function ($task) use ($userSkills, $completedTaskIds) {
                // 1. Keep Completed
                if (in_array($task->id, $completedTaskIds)) {
                    return true;
                }

                // 2. Check Skills (Show if skills match, regardless of prerequisites)
                $taskSkills = $task->skills->pluck('id')->toArray();
                if (!empty($taskSkills)) {
                    $matchingSkills = array_intersect($taskSkills, $userSkills);
                    if (count($matchingSkills) !== count($taskSkills)) {
                        return false; // Missing skills
                    }
                }

                return true;
            });

            $activeProject->setRelation('tasks', $filteredTasks->values());

            // Determine the current task (first non-completed task from the filtered list)
            $currentTask = $filteredTasks->first(function ($task) use ($completedTaskIds) {
                return !in_array($task->id, $completedTaskIds);
            });

            // If no current task found (all completed?), maybe show the last one or a summary
            if (!$currentTask) {
                $currentTask = $filteredTasks->last();
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

    public function downloadResources(Task $task)
    {
        if (!$task->resource_file_path) {
            abort(404);
        }

        // Check if user is enrolled in the project
        $user = auth()->user();
        if (!$user->projects()->where('projects.id', $task->project_id)->exists()) {
            abort(403);
        }

        return Storage::download($task->resource_file_path);
    }
}
