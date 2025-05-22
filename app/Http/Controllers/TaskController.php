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

class TaskController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $tasks = $user->hasRole('admin')
            ? Task::with(['project', 'creator', 'priority', 'contractor', 'status'])->get()
            : Task::whereIn('project_id', $user->projects()->pluck('projects.id'))
                ->with(['project', 'creator', 'priority', 'contractor', 'status'])
                ->get();

        return inertia('Task/Index', [
            'tasks' => TaskResource::collection($tasks)->resolve(),
            'auth' => [
                'user' => [
                    'id' => $user->id,
                ]
            ]
        ]);
    }

    public function create()
    {
        $projects = Project::with('users:id,name')->select('id', 'title')->get();
        $priorities = TaskPriority::select('id', 'name', 'color')->get();
        return inertia('Task/Create', [
            'projects' => $projects,
            'priorities' => $priorities,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $task = Task::create(
            array_merge(
                $request->validated(),
                ['creator_id' => auth()->id()]
            )
        );
        if ($request->hasFile('files')) {
            $task->storeFiles($request->file('files'));
        }

        // Добавляем задачу в очередь вместо прямой отправки
        SendTaskNotification::dispatch($task);

        return redirect()->route('task.index');
    }


    public function show(Task $task)
    {
        $task->load('creator', 'messages.user', 'priority', 'contractor', 'status');
        $task = TaskResource::make($task)->resolve();

        return inertia('Task/Show', compact('task'));
    }


    public function edit(Task $task)
    {
        $projects = Project::with('users:id,name')->select('id', 'title')->get();
        $priorities = TaskPriority::select('id', 'name', 'color')->get();
        $statuses = Status::orderBy('order')->get();
        return inertia('Task/Edit', [
            'task' => $task,
            'projects' => $projects,
            'priorities' => $priorities,
            'statuses' => $statuses,
        ]);
    }


    public function update(Task $task, UpdateRequest $request)
    {
        // Основное обновление данных
        $task->update($request->validated());

        // Обработка удаления файлов
        if ($request->has('files_to_delete')) {
            // Удаляем файлы из хранилища
            foreach ($request->input('files_to_delete') as $filePath) {
                Storage::disk('public')->delete($filePath);
            }

            // Удаляем файлы из записи в БД
            $task->removeFiles($request->input('files_to_delete'));
        }

        // Обработка добавления новых файлов
        if ($request->hasFile('files')) {
            $task->storeFiles($request->file('files'));
        }

        return redirect()->route('task.index');
    }

    public function delete(Task $task)
    {
        $task->delete();
        return redirect()->route('task.index');
    }
}
