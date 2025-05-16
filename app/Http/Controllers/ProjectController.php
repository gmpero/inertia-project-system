<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
   public function index()
   {
       $projects = Project::all();
       $projects = ProjectResource::collection($projects)->resolve();
       return inertia('Project/Index', compact('projects'));
   }

    public function create()
    {
        $users = User::all();
        return inertia('Project/Create', [
            'users' => $users,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $project = Project::create($request->validated());

        // Прикрепляем выбранных пользователей к проекту
        if ($request->has('user_ids')) {
            $project->users()->attach($request->user_ids);
        }

        return redirect()->route('project.index');
    }

    public function show(Project $project)
    {
        $project = ProjectResource::make($project)->resolve();
        return inertia('Project/Show', compact('project'));
    }

    public function edit(Project $project)
    {
        $users = User::all();

        // Возвращаем проект и всех пользователей в ответе
        return inertia('Project/Edit', [
            'project' => $project,
            'users' => $users,
        ]);
    }

    public function update(Project $project, UpdateRequest $request)
    {
        $project->update($request->validated());
        if ($request->has('user_ids')) {
            $project->users()->attach($request->user_ids);
        }
        return redirect()->route('project.index');
    }

    public function delete(Project $project)
    {
        $project->delete();
        return redirect()->route('project.index');
    }
}
