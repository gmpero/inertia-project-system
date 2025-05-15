<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\StoreRequest;
use App\Http\Requests\Message\UpdateRequest;
use App\Models\TaskMessage;
use http\Message;


class MessageController extends Controller
{
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        TaskMessage::create($validated);

        return redirect()->route('task.show', $validated['task_id']);
    }

    public function update(TaskMessage $message, UpdateRequest $request)
    {
        $message->update($request->validated());
    }

    public function delete(TaskMessage $message)
    {
        $message->delete();
    }
}
