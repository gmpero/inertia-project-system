<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\StoreRequest;
use App\Http\Requests\Message\UpdateRequest;
use App\Mail\MessageNotificationMail;
use App\Models\TaskMessage;
use http\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class MessageController extends Controller
{
    public function store(StoreRequest $request)
    {
        // Добавляем user_id к валидированным данным
        $validated = array_merge(
            $request->validated(),
            ['user_id' => Auth::id()] // Добавляем ID текущего пользователя
        );

        // Создаем сообщение
        $message = TaskMessage::create($validated);

        // Получаем всех участников проекта, связанного с задачей
        $recipients = $message->task->project->users()
            ->where('users.id', '!=', $message->user_id) // Исключаем отправителя
            ->get();

        // Отправка каждому получателю
        foreach ($recipients as $recipient) {
            Mail::to($recipient->email)->queue(new MessageNotificationMail($message));
        }

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
