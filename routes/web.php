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

Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = auth()->user();
    $hasSkills = $user->skills()->exists();
    $hasBio = !empty($user->bio);

    $recommendedProjects = [];
    if ($hasSkills) {
        // Get projects that match user skills
        // For now, just get all projects with their skills and tasks count
        $recommendedProjects = \App\Models\Project::with(['skills', 'tasks'])
            ->take(6)
            ->get()
            ->map(function ($project) {
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'description' => $project->description,
                    'difficulty_level' => ucfirst($project->difficulty_level),
                    'skills' => $project->skills->pluck('name'),
                    'tasks_count' => $project->tasks->count(),
                ];
            });
    }

    return Inertia::render('Dashboard', [
        'profileCompleted' => $hasSkills || $hasBio,
        'recommendedProjects' => $recommendedProjects
    ]);
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/skills', [SkillController::class, 'create'])->name('profile.skills');
    Route::post('/profile/skills', [SkillController::class, 'store'])->name('profile.skills.store');
});
