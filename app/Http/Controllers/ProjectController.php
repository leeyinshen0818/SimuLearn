<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['skills', 'tasks'])->get();

        /** @var \App\Models\User|null $user */
        $user = auth()->user();
        $userSkills = $user ? $user->skills()->pluck('skills.id')->toArray() : [];

        return Inertia::render('Project/Index', [
            'projects' => $projects,
            'userSkills' => $userSkills
        ]);
    }

    public function show(Project $project)
    {
        $project->load(['skills', 'tasks.skills', 'tasks.prerequisites', 'tasks.userTasks' => function ($query) {
            $query->where('user_id', auth()->id());
        }]);

        /** @var \App\Models\User|null $user */
        $user = auth()->user();
        $userSkills = $user ? $user->skills()->pluck('skills.id')->toArray() : [];

        $recommendedPath = $this->getRecommendedTaskPath($project, $userSkills);

        return Inertia::render('Project/Show', [
            'project' => $project,
            'userSkills' => $userSkills,
            'recommendedPath' => $recommendedPath
        ]);
    }

    private function getRecommendedTaskPath($project, $userSkills)
    {
        $tasks = $project->tasks;
        $completedTaskIds = $tasks->filter(function ($task) {
            return $task->userTasks->where('status', 'completed')->isNotEmpty();
        })->pluck('id')->toArray();

        // Filter for available tasks (not completed, prerequisites met)
        $availableTasks = $tasks->filter(function ($task) use ($completedTaskIds) {
            // Skip if already completed
            if (in_array($task->id, $completedTaskIds)) {
                return false;
            }

            // Check prerequisites
            if ($task->prerequisites->isEmpty()) {
                return true;
            }

            foreach ($task->prerequisites as $prerequisite) {
                if (!in_array($prerequisite->id, $completedTaskIds)) {
                    return false; // Locked
                }
            }

            return true;
        });

        if ($availableTasks->isEmpty()) {
            return [];
        }

        // Filter tasks where user has ALL required skills
        $recommendedTasks = $availableTasks->filter(function ($task) use ($userSkills) {
            $taskSkills = $task->skills->pluck('id')->toArray();

            if (empty($taskSkills)) {
                return true;
            }

            $matchingSkills = array_intersect($taskSkills, $userSkills);
            return count($matchingSkills) === count($taskSkills);
        });

        return $recommendedTasks->values();
    }
}
