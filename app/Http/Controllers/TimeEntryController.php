<?php

namespace App\Http\Controllers;
use App\Http\Requests\TimeEntry\StoreRequest;

use App\Models\Task;
use App\Models\TimeEntry;

class TimeEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        TimeEntry::create($validated);

        return back()->with('success', 'Время успешно учтено');
    }

    public function report(Task $task)
    {
        $timeEntries = TimeEntry::with('user')
            ->where('task_id', $task->id)
            ->orderByDesc('created_at')
            ->get();

        $totalTime = $timeEntries->sum('minutes')/60;

        $timeByUsers = $timeEntries->groupBy('user_id')->map(function ($entries) {
            return [
                'user' => $entries->first()->user,
                'total_time' => $entries->sum('minutes')/60
            ];
        });

        return inertia('Report/TaskReport', [
            'task' => $task,
            'timeEntries' => $timeEntries,
            'totalTime' => $totalTime,
            'timeByUsers' => $timeByUsers
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TimeEntry $timeEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimeEntry $timeEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimeEntry $timeEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimeEntry $timeEntry)
    {
        //
    }
}
