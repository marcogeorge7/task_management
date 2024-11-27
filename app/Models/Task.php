<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'assigned_user_id', 'parent_task_id',
        'name', 'description', 'status', 'priority'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function subtasks() {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    public function dependencies() {
        return $this->belongsToMany(Task::class, 'task_dependencies', 'task_id', 'dependency_task_id');
    }

    public function histories() {
        return $this->hasMany(TaskHistory::class);
    }
}
