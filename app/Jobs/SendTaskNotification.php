<?php

namespace App\Jobs;

use App\Mail\TaskCreatedMail;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTaskNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function handle()
    {
        // Проверяем, что исполнитель существует
        if ($this->task->contractor && $this->task->contractor->email) {
            Mail::to($this->task->contractor->email)
                ->send(new TaskCreatedMail($this->task));
        }
    }

    public function failed(\Throwable $exception)
    {
        \Log::error('Failed to send task created notification', [
            'task_id' => $this->task->id,
            'error' => $exception->getMessage()
        ]);
    }
}
