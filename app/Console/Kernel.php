<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\CheckOverdueTasks;
use App\Http\Controllers\PdfController;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CheckOverdueTasks::class,
        GenerateAndSendDailyPdf::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('tasks:check-overdue')->dailyAt('09:00');
        $schedule->command('tasks:generate-recurring')->daily();
        $schedule->command('tasks:send-reminders')->everyFiveMinutes();
        
        // New task: Generate and send daily PDF at 19:00 from Sunday to Thursday
        $schedule->call(function () {
            // You can use the controller method directly
            (new PdfController)->generateDailyPdfAndSendEmail(new \Illuminate\Http\Request());
        })->days([0, 1, 2, 3, 4]) // 0 = Sunday, 1 = Monday, ..., 4 = Thursday
        ->at('17:00');

        $schedule->call(function () {
            // Call the method to move unfinished tasks and send email summary
            \App\Http\Controllers\TasksController::moveUnfinishedTasksToNextBusinessDay();
        })->dailyAt('16:30');

        $schedule->call(function () {
            // You can use the controller method directly
            (new PdfController)->generateDailyCollectionPdfAndSendEmail(new \Illuminate\Http\Request());
        })->days([0, 1, 2, 3, 4]) // 0 = Sunday, 1 = Monday, ..., 4 = Thursday
        ->at('5:00');

        
        // Add this line to schedule the inspire command every minute
        $schedule->command('inspire')->everyMinute();
    }
    protected $middleware = [
        // other middleware
        \App\Http\Middleware\CorsMiddleware::class,
    ];
}
