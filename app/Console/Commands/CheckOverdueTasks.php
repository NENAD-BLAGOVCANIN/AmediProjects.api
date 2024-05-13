<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckOverdueTasks extends Command
{
    protected $signature = 'tasks:check-overdue';
    protected $description = 'Check for overdue tasks and create notifications';

    public function handle()
    {
        $overdueTasks = Task::where('due_date', '<', Carbon::now())
            ->where('status', '!=', Task::STATUS_DONE)
            ->get();

        foreach ($overdueTasks as $task) {
            $notification = new Notification();
            $notification->title = 'Task Overdue';
            $notification->body = "The task '{$task->subject}' is overdue.";
            $notification->user_id = $task->assigned_to;
            $notification->save();
        }

        $this->info('Overdue tasks checked and notifications created.');
    }
}
