<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;
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
        return inertia('Project/Create');
    }

    public function store(StoreRequest $request)
    {
        Project::create($request->validated());
        return redirect()->route('project.index');
    }

    public function show(Project $project)
    {
        $project = ProjectResource::make($project)->resolve();
        return inertia('Project/Show', compact('project'));
    }

    public function edit(Project $project)
    {
        return inertia('Project/Edit', compact('project'));
    }

    public function update(Project $project, UpdateRequest $request)
    {
        $project->update($request->validated());
        return redirect()->route('project.index');
    }

    public function delete(Project $project)
    {
        $project->delete();
        return redirect()->route('project.index');
    }
}
