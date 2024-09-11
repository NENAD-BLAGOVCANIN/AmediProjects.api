<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\PdfController;
use Illuminate\Http\Request;

class GenerateAndSendDailyPdf extends Command
{
    // The name and signature of the console command.
    protected $signature = 'pdf:generate-and-send';

    // The console command description.
    protected $description = 'Generate and send the daily PDF report';

    // Execute the console command.
    public function handle()
    {
        $controller = new PdfController();
        $controller->generateDailyPdfAndSendEmail(new Request());

        $this->info('Daily PDF generated and sent successfully.');
    }
}
