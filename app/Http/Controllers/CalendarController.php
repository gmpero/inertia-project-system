<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Resources\Task\TaskResource;
use App\Jobs\SendTaskNotification;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskPriority;
use Illuminate\Support\Facades\Storage;

class CalendarController extends Controller
{
    public function index()
    {
        $query = Task::query()
            ->with('project') // Подгружаем связанный проект
            ->select(['id', 'title', 'start_date as start', 'due_date as end', 'description', 'project_id', 'creator_id', 'priority_id']);

        // Если пользователь не админ, показываем только его задачи
        if (!auth()->user()->is_admin) {
            $query->where('creator_id', auth()->id());
        }

        $events = $query->get()
            ->map(function ($task) {
                $priorityName = optional($task->priority)->name ?? 'normal';
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'color' => $task->project->color,
                    'start' => $task->start,
                    'end' => $task->end,
                    'extendedProps' => [
                        'description' => $task->description,
                        'project' => $task->project->title,
                        'creator' => $task->creator->name ?? 'Неизвестный автор',

                        'priority' => $priorityName
                    ],
                ];
            });
//        dd($events);

        return inertia('Calendar/Index', [
            'events' => $events->toArray()
        ]);
    }

}
