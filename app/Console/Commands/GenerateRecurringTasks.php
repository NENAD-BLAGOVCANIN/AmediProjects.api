<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Carbon\Carbon;

class GenerateRecurringTasks extends Command
{
    protected $signature = 'tasks:generate-recurring';
    protected $description = 'Generate instances of recurring tasks';

    public function handle()
    {
        $tasks = Task::whereNotNull('recurrence_type')
                     ->whereNotNull('recurrence_end_date')
                     ->where('due_date', '<', Carbon::now())
                     ->get();

        foreach ($tasks as $task) {
            $this->generateRecurringTasks($task);
        }
    }

    private function generateRecurringTasks(Task $task)
    {
        $currentDate = $task->due_date;
        $endDate = $task->recurrence_end_date;
        $recurrenceType = $task->recurrence_type;

        while ($currentDate < $endDate) {
            switch ($recurrenceType) {
                case 'daily':
                    $currentDate = $currentDate->addDay();
                    break;
                case 'weekly':
                    $currentDate = $currentDate->addWeek();
                    break;
                case 'monthly':
                    $currentDate = $currentDate->addMonth();
                    break;
            }

            if ($currentDate > $endDate) {
                break;
            }

            $newTask = $task->replicate();
            $newTask->due_date = $currentDate;
            $newTask->save();
        }
    }
}