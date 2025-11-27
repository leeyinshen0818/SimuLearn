<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'title', 'description', 'category'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function prerequisites()
    {
        return $this->belongsToMany(Task::class, 'task_dependencies', 'task_id', 'prerequisite_task_id');
    }

    public function dependents()
    {
        return $this->belongsToMany(Task::class, 'task_dependencies', 'prerequisite_task_id', 'task_id');
    }

    public function userTasks()
    {
        return $this->hasMany(UserTask::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'task_skill');
    }
}
