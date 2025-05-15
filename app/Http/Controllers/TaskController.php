<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Resources\Task\MessageResource;
use App\Http\Resources\Task\TaskResource;
use App\Models\Project;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('project')->get(); // Загружаем задачи с проектами
        $tasks = TaskResource::collection($tasks)->resolve();
        return inertia('Task/Index', compact('tasks'));
    }

    public function create()
    {
        $projects = Project::select('id', 'title')->get();
        return inertia('Task/Create', [
            'projects' => $projects
        ]);
    }

    public function store(StoreRequest $request)
    {
        Task::create($request->validated());
        return redirect()->route('task.index');
    }


    public function show(Task $task)
    {
        $task->load('messages');
        $task = TaskResource::make($task)->resolve();
        return inertia('Task/Show', compact('task'));
    }



    public function edit(Task $task)
    {
        return inertia('Task/Edit', compact('task'));
    }


    public function update(Task $task, UpdateRequest $request)
    {
        $task->update($request->validated());
        return redirect()->route('task.index');
    }

    public function delete(Task $task)
    {
        $task->delete();
        return redirect()->route('task.index');
    }
}
