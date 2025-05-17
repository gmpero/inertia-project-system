<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\TaskMessage;

class MessageNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $task;

    public function __construct(TaskMessage $message)
    {
        $this->message = $message;
        $this->task = $message->task;
    }

    public function build()
    {
        return $this
            ->subject("Новое сообщение в задаче: {$this->task->title}")
            ->markdown('emails.message_notification', [
                'message' => $this->message,
                'task' => $this->task,
                'taskUrl' => route('task.show', $this->task->id)
            ]);
    }
}
