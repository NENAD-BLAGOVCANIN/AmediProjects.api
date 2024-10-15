<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\PdfController;

Artisan::command('inspire', function () {
    $quote = Inspiring::quote();
    Log::info("Inspire Command: " . $quote);
})->purpose('Display an inspiring quote');

// Schedule tasks directly in routes/console.php
Schedule::call(function () {
    (new PdfController)->generateDailyPdfAndSendEmail(new \Illuminate\Http\Request());
})->days([0, 1, 2, 3, 4]) // 0 = Sunday, 1 = Monday, ..., 4 = Thursday
->at('17:00');
Schedule::call(function () {
    (new PdfController)->generateWeeklyPdfAndSendEmail(new \Illuminate\Http\Request());
})->days([5]) // 0 = Sunday, 1 = Monday, ..., 4 = Thursday
->at('17:00');
Schedule::call(function () {
    (new PdfController)->generateDailyCollectionPdfAndSendEmail(new \Illuminate\Http\Request());
})->days([0, 1, 2, 3, 4]) // 0 = Sunday, 1 = Monday, ..., 4 = Thursday
->at('5:00');
Schedule::call(function () {
    (new TasksController)->moveUnfinishedTasksToNextBusinessDay();
})->dailyAt('16:30');

