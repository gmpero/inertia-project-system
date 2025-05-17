<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Task;

class TaskCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $creator;
    public $contractor;

    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->creator = $task->creator; // Связь в модели Task: creator()
        $this->contractor = $task->contractor; // Связь в модели Task: contractor()
    }

    public function build()
    {
        return $this
            ->subject("Новая задача: {$this->task->title}")
            ->markdown('emails.task_created'); // Используем Markdown-шаблон
    }
}
