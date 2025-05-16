<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskPriority extends Model
{
    protected $guarded = false;
    protected $table = 'task_priorities';
    use HasFactory;
}
