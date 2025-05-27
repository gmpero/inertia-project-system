<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Resources\Task\TaskResource;
use App\Jobs\SendTaskNotification;
use App\Models\Project;
use App\Models\Status;
use App\Models\Task;
use App\Models\TaskPriority;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function generateReport($projectId)
    {
        $project = Project::with('tasks')->findOrFail($projectId);
        $tasks = $project->tasks;

        // Общее количество задач
        $totalTasks = $tasks->count();

        // Выполненные задачи (статус_id = 4)
        $completedTasks = $tasks->where('status_id', 4)->count();
        $completedTasksDetails = $tasks
            ->where('status_id', 4)
            ->map(function ($task) {
                return [
                    'id' => $task->id,
                    'name' => $task->title,
                    'assigned_to' => $task->contractor->name ?? 'Не назначен',
                    'completed_at' => $task->updated_at->format('d.m.Y'), // или отдельное поле completed_at, если есть
                    'end_date' => $task->due_date,
                ];
            });

        // Невыполненные задачи
        $incompleteTasks = $totalTasks - $completedTasks;
        $incompleteTasksDetails = $tasks
            ->where('status_id', '!=', 4)
            ->map(function ($task) {
                return [
                    'id' => $task->id,
                    'name' => $task->title,
                    'assigned_to' => $task->contractor->name ?? 'Не назначен',
                    'end_date' => $task->due_date,
                    'is_overdue' => now() > $task->due_date,
                ];
            });

        // Просроченные задачи
        $overdueTasks = $incompleteTasksDetails->filter(fn($task) => $task['is_overdue'])->count();

        // Процент завершения проекта
        $completionPercentage = $totalTasks > 0
            ? round(($completedTasks / $totalTasks) * 100, 2)
            : 0;

        return inertia('Report/ProjectReport', [
            'project' => $project,
            'reportData' => [
                'totalTasks' => $totalTasks,
                'completedTasks' => $completedTasks,
                'completedTasksDetails' => $completedTasksDetails, // Добавлено
                'incompleteTasks' => $incompleteTasks,
                'overdueTasks' => $overdueTasks,
                'completionPercentage' => $completionPercentage,
                'incompleteTasksDetails' => $incompleteTasksDetails,
            ],
        ]);
    }
}
