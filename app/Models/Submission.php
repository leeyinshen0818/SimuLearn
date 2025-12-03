<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_task_id',
        'file_path',
        'file_name',
        'attempt_number',
        'status',
        'feedback',
        'score',
    ];

    public function userTask()
    {
        return $this->belongsTo(UserTask::class);
    }
}
