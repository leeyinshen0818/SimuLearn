<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id', 'task_id', 'status', 'completed_at'];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
