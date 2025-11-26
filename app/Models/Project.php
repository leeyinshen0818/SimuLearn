<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'difficulty_level'];

    public function tags()
    {
        return $this->hasMany(ProjectTag::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function userProjects()
    {
        return $this->hasMany(UserProject::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class)->withPivot('required_proficiency')->withTimestamps();
    }
}
