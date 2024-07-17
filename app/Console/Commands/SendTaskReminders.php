<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\User;
use App\Helpers\NotificationHelper;
use Carbon\Carbon;

class SendTaskReminders extends Command
{
    protected $signature = 'tasks:send-reminders';
    protected $description = 'Send reminders for tasks with upcoming due dates';

    public function handle()
    {
        $tasks = Task::where('reminder_enabled', true)
                     ->where('reminder_date', '<=', Carbon::now())
                     ->get();

        foreach ($tasks as $task) {
            $user = User::findOrFail($task->assigned_to);
            $notificationTitle = "Task Reminder: {$task->subject}";
            $notificationBody = "Hello! This is a reminder for your task: {$task->subject}.";

            NotificationHelper::createNotificationForUser($user, $notificationTitle, $notificationBody);

            // Disable further reminders for this task
            $task->reminder_enabled = false;
            $task->save();
        }
    }
}
