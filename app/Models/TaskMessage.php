<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskMessage extends Model
{
    protected $guarded = false;
    protected $table = 'task_messages';
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
