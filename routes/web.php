<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return Inertia::render('LandingPage');
});

Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'signup']);

use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MyProjectController;
use App\Http\Controllers\SubmissionController;

Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = auth()->user();
    $hasSkills = $user->skills()->exists();
    $hasBio = !empty($user->bio);

    $recommendedProjects = [];
    if ($hasSkills) {
        $userSkillIds = $user->skills()->pluck('skills.id')->toArray();

        $recommendedProjects = \App\Models\Project::with(['skills', 'tasks'])
            ->get()
            ->map(function ($project) use ($userSkillIds) {
                $matchingSkillsCount = $project->skills->whereIn('id', $userSkillIds)->count();
                $totalSkillsCount = $project->skills->count();
                $matchPercentage = $totalSkillsCount > 0 ? ($matchingSkillsCount / $totalSkillsCount) * 100 : 0;

                // Calculate weighted score: Match Percentage * Difficulty Weight
                // Beginner: 1, Intermediate: 2, Advanced: 3
                $difficultyWeight = match ($project->difficulty_level) {
                    'intermediate' => 2,
                    'advanced' => 3,
                    default => 1,
                };

                // Boost score if user has high match on harder projects
                $recommendationScore = $matchPercentage * $difficultyWeight;

                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'description' => $project->description,
                    'difficulty_level' => ucfirst($project->difficulty_level),
                    'skills' => $project->skills->pluck('name'),
                    'tasks_count' => $project->tasks->count(),
                    'match_percentage' => $matchPercentage,
                    'recommendation_score' => $recommendationScore,
                ];
            })
            ->sortByDesc('recommendation_score')
            ->take(3)
            ->values();
    }

    $enrolledProjectsCount = $user->projects()->count();
    $completedTasksCount = $user->tasks()->where('status', 'completed')->count();
    $skillsCount = $user->skills()->count();

    return Inertia::render('Dashboard', [
        'profileCompleted' => $hasSkills || $hasBio,
        'recommendedProjects' => $recommendedProjects,
        'enrolledProjectsCount' => $enrolledProjectsCount,
        'completedTasksCount' => $completedTasksCount,
        'skillsCount' => $skillsCount,
    ]);
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/skills', [SkillController::class, 'create'])->name('profile.skills');
    Route::post('/profile/skills', [SkillController::class, 'store'])->name('profile.skills.store');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/project/{project}', [ProjectController::class, 'show'])->name('project.show');
    Route::post('/projects/{project}/start', [MyProjectController::class, 'store'])->name('projects.start');
    Route::get('/my-projects', [MyProjectController::class, 'index'])->name('my-projects.index');
    Route::delete('/my-projects/{project}', [MyProjectController::class, 'destroy'])->name('my-projects.destroy');
    Route::get('/tasks/{task}/download-resources', [MyProjectController::class, 'downloadResources'])->name('tasks.download-resources');
    Route::post('/tasks/{task}/submit', [SubmissionController::class, 'store'])->name('tasks.submit');
    Route::delete('/submissions/{submission}', [SubmissionController::class, 'destroy'])->name('submissions.destroy');
});
