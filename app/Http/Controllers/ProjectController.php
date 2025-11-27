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
        $userSkills = auth()->user() ? auth()->user()->skills()->pluck('skills.id')->toArray() : [];

        return Inertia::render('Project/Index', [
            'projects' => $projects,
            'userSkills' => $userSkills
        ]);
    }

    public function show(Project $project)
    {
        $project->load(['skills', 'tasks.skills']);

        $userSkills = auth()->user() ? auth()->user()->skills()->pluck('skills.id')->toArray() : [];

        return Inertia::render('Project/Show', [
            'project' => $project,
            'userSkills' => $userSkills
        ]);
    }
}
