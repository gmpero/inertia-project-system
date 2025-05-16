<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = false;
    protected $table = 'tasks';
    use HasFactory;

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function messages()
    {
        return $this->hasMany(TaskMessage::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function priority()
    {
        return $this->belongsTo(TaskPriority::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($task) {
            if (empty($task->task_code)) {
                // Получаем последний номер задачи для этого проекта
                $lastTaskNumber = $task->project->tasks()
                    ->where('task_code', 'like', $task->project->code . '-%')
                    ->count();

                // Генерируем новый код задачи
                $task->task_code = $task->project->code . '-' . ($lastTaskNumber + 1);
            }
        });
    }
}
