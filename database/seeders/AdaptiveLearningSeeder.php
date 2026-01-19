<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Skill;
use App\Models\Task;
use Illuminate\Database\Seeder;

class AdaptiveLearningSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the Evaluation Project
        $project = Project::create([
            'title' => 'Adaptive System Logic Test',
            'description' => 'A control group project designed to test system behavior. Tasks are intentionally trivial to allow rapid completion.',
            'difficulty_level' => 'advanced', // Using 'advanced' as 'adaptive' is not in ENUM
        ]);

        // 2. Assign a broad range of skills to test profile updates
        $skills = ['System Architecture', 'Testing', 'Optimization', 'Debug', 'Analytics'];
        foreach ($skills as $skillName) {
            $skill = Skill::firstOrCreate(['name' => $skillName]);
            $project->skills()->attach($skill->id);
        }

        // 3. Create a spectrum of tasks (Simulating a long curriculum)
        $tasks = [
            [
                'title' => '[L1] Syntax Check',
                'description' => 'A trivial task to verify beginner skill tracking. Submit a PHP file that simply accepts a variable.',
                'category' => 'Syntax',
                'difficulty' => 'beginner',
                'code_answer' => 'return true;',
                'expected_outcome' => 'System accepts the solution. Beginner logic paths are validated.'
            ],
            [
                'title' => '[L2] Loop Logic',
                'description' => 'Test intermediate logic processing.',
                'category' => 'Logic',
                'difficulty' => 'intermediate',
                'code_answer' => 'foreach($a as $b) {}',
                'expected_outcome' => 'Intermediate progress bar updates on dashboard.'
            ],
            [
                'title' => '[L3] Data Structures',
                'description' => 'Verify array handling capabilities.',
                'category' => 'Structures',
                'difficulty' => 'intermediate',
                'code_answer' => 'array_push($a, $b);',
                'expected_outcome' => 'Unlocks access to optimization tasks.'
            ],
            [
                'title' => '[L4] Complexity Analysis',
                'description' => 'Test skipping logic relative to L1/L2.',
                'category' => 'Theory',
                'difficulty' => 'advanced',
                'code_answer' => '// O(n) complexity verified',
                'expected_outcome' => 'Completing this should auto-satisfy previous levels if Adaptive Logic is active.'
            ],
            [
                'title' => '[L5] System Optimization',
                'description' => 'The final mastery task.',
                'category' => 'Optimization',
                'difficulty' => 'expert',
                'code_answer' => 'optimize_all();',
                'expected_outcome' => 'Project marked Complete. Skill Profile updated with Expert badge.'
            ]
        ];

        foreach ($tasks as $taskData) {
            $task = Task::create([
                'project_id' => $project->id,
                'title' => $taskData['title'],
                'description' => $taskData['description'],
                'category' => $taskData['category'],
                'expected_outcome' => $taskData['expected_outcome']
            ]);

            // Attach a skill to each task
            $task->skills()->attach(Skill::where('name', $skills[array_rand($skills)])->first()->id);
        }
    }
}
