<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\CheckOverdueTasks;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CheckOverdueTasks::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('tasks:check-overdue')->dailyAt('09:00');
    }
}
