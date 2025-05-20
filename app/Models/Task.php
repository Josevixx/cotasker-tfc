<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'due_date', 'assigned_to', 'task_list_id'];

    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_REVIEW = 'review';
    const STATUS_BLOCKED = 'paused';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    public static function statuses()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_IN_PROGRESS,
            self::STATUS_REVIEW,
            self::STATUS_BLOCKED,
            self::STATUS_COMPLETED,
            self::STATUS_CANCELLED,
        ];
    }

    public function taskList()
    {
        return $this->belongsTo(TaskList::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
