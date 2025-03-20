<?php 
class Task
{
    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_REVIEW = 'review';
    const STATUS_BLOCKED = 'paused';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = ['title', 'description', 'status', 'task_list_id', 'assigned_to'];

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
}

?>