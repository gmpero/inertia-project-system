<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Resources\Task\MessageResource;
use App\Http\Resources\Task\TaskResource;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\User;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['project', 'creator', 'priority', 'contractor'])->get();
        $tasks = TaskResource::collection($tasks)->resolve();
        return inertia('Task/Index', compact('tasks'));
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
        return redirect()->route('task.index');
    }


    public function show(Task $task)
    {
        $task->load('creator', 'messages.user', 'priority', 'contractor');
        $task = TaskResource::make($task)->resolve();
        return inertia('Task/Show', compact('task'));
    }



    public function edit(Task $task)
    {
        $projects = Project::with('users:id,name')->select('id', 'title')->get();
        $priorities = TaskPriority::select('id', 'name', 'color')->get();
        return inertia('Task/Edit', [
            'task' => $task,
            'projects' => $projects,
            'priorities' => $priorities,
        ]);
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
