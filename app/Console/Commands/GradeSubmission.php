<?php

namespace App\Console\Commands;

use App\Models\Submission;
use App\Services\GradingService;
use Illuminate\Console\Command;

class GradeSubmission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grade:submission {id : The ID of the submission to grade}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually trigger grading for a specific submission ID';

    /**
     * Execute the console command.
     */
    public function handle(GradingService $grader)
    {
        $id = $this->argument('id');
        $this->info("Finding submission #{$id}...");

        $submission = Submission::with('userTask.task')->find($id);

        if (!$submission) {
            $this->error("Submission not found!");
            return;
        }

        $this->info("Submission found for Task: " . $submission->userTask->task->title);
        $this->info("File: " . $submission->file_path);

        try {
            $this->info("Starting grading process...");

            $result = $grader->grade($submission);

            $this->info("------------------------------------------------");
            $this->info("Grading Complete!");
            $this->info("Score: " . $result['score']);
            $this->info("Feedback Preview: " . substr($result['feedback'], 0, 100) . "...");
            $this->info("------------------------------------------------");

        } catch (\Exception $e) {
            $this->error("Error during grading: " . $e->getMessage());
            $this->error($e->getTraceAsString());
        }
    }
}
