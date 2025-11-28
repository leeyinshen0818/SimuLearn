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

        return Inertia::render('Project/Show', [
            'project' => $project,
            'userSkills' => $userSkills
        ]);
    }
}
