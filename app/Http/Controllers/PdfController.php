<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\MonthlyCollection;
use App\Models\SummaryDay;
use App\Models\SummaryInstallation;
use App\Models\SummaryPlanner;
use App\Models\PriceOffers;
use App\Models\Task; // Assuming Task is the model for user tasks
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\Account;

class PdfController extends Controller
{
    public function generatePdf(Request $request)
    {
        $data = $request->all();
    
        // Create an instance of MPDF
        $mpdf = new Mpdf([
            'default_font' => 'dejavusans',
            'mode' => 'utf-8',
            'format' => 'A4',
            'directionality' => 'rtl'
        ]);

        $accountController = new AccountController();
        $accountController->store($request);

//    // שליפת החשבון שנוצר
//    $account = Account::with('accountDetails', 'project.manager')->latest()->first();

//    // יצירת נתונים לתצוגה
//    $pdfData = [
//        'account' => $account,
//        'project' => $account->project,
//        // כל נתון נוסף שאתה צריך בתבנית
//    ];
        

        // Load HTML content with inline CSS for RTL support
        $html = view('pdf_template', compact('data'))->render();
    
        // Write the HTML content to the PDF
        $mpdf->WriteHTML($html);
    
        // Save the PDF to a file
        $pdfFilePath = storage_path('app/public/document.pdf');
        $mpdf->Output($pdfFilePath, 'F');
    
        // Email addresses to send the PDF
        $recipientEmails = ['eranlips@gmail.com', 'nitsanrozen01@gmail.com' , 'nirproject.office@gmail.com', 'niramidi@gmail.com'];
        if (isset($data['email'])) {
            $recipientEmails[] = $data['email'];
        }
    
        // Send email with the PDF as an attachment
        Mail::send([], [], function ($message) use ($pdfFilePath, $recipientEmails) {
            $message->to($recipientEmails)
                    ->subject('הצעת מחיר מאמדי פרוייקטים')
                    ->attach($pdfFilePath);
        });
    
        return response()->json(['message' => 'PDF generated and sent to email successfully.'],200);
    }
    public function getWeeklyOffersCount()
    {
        $count = PriceOffers::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        return response()->json(['weekly_offer_count' => $count]);
    }
    public function generateAccountDetailsPdf(Request $request)
    {
        $data = $request->all();
    
        // Create an instance of MPDF
        $mpdf = new Mpdf([
            'default_font' => 'dejavusans',  // Use a font that supports Hebrew
            'mode' => 'utf-8', // Set the document encoding to UTF-8
            'format' => 'A4',
            'directionality' => 'rtl'  // Set the direction to RTL
        ]);
    
        // Load HTML content with inline CSS for RTL support
        $html = view('account_details_pdf_template', compact('data'))->render();
    
        // Write the HTML content to the PDF
        $mpdf->WriteHTML($html);
    
        // Save the PDF to a file
        $pdfFilePath = storage_path('app/public/account_details.pdf');
        $mpdf->Output($pdfFilePath, 'F');
    
        // Email addresses to send the PDF
        $recipientEmails = ['eranlips@gmail.com', 'nitsanrozen01@gmail.com' , 'nirproject.office@gmail.com', 'niramidi@gmail.com'];
        if (isset($data['emailSent'])) {
            $recipientEmails[] = $data['emailSent'];
        }
    
        // Send email with the PDF as an attachment
        Mail::send([], [], function ($message) use ($pdfFilePath, $recipientEmails) {
            $message->to($recipientEmails)
                    ->subject('פירוט סיכום חשבון - ניר אמידי פרוייקטים בע"מ')
                    ->attach($pdfFilePath);
        });
    
        return response()->json(['message' => 'Account details PDF generated and sent to email successfully.'], 200);
    }
    
    

    public function generatePdfAndSendEmail(Request $request)
    {
        // Fetch data for MonthlyCollection
        $monthlyCollections = MonthlyCollection::with('project:id,name')->get();

        // Get current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Fetch data for the current month's summary records
        $summaryDays = SummaryDay::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->get();

        $summaryInstallations = SummaryInstallation::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->get();

        $summaryPlanners = SummaryPlanner::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->get();

        $data = [
            'monthlyCollections' => $monthlyCollections,
            'summaryDays' => $summaryDays,
            'summaryInstallations' => $summaryInstallations,
            'summaryPlanners' => $summaryPlanners,
        ];

        // Create an instance of MPDF
        $mpdf = new Mpdf([
            'default_font' => 'dejavusans',
            'mode' => 'utf-8',
            'format' => 'A4',
            'directionality' => 'rtl'
        ]);

        // Load HTML content with inline CSS for RTL support
        $html = view('monthly_summary_pdf_template', compact('data'))->render();

        // Write the HTML content to the PDF
        $mpdf->WriteHTML($html);

        // Save the PDF to a file
        $pdfFilePath = storage_path('app/public/monthly_summary.pdf');
        $mpdf->Output($pdfFilePath, 'F');

        // Send email with the PDF as an attachment
        Mail::send([], [], function ($message) use ($pdfFilePath) {
            $message->to('eranlips@gmail.com','nitsanrozen01@gmail.com')
                    ->subject('Monthly Summary Report')
                    ->attach($pdfFilePath);
        });

        return response()->json(['message' => 'PDF generated and sent to email successfully.']);
    }
  

    public function generateDailyPdfAndSendEmail(Request $request)
{
    // Get the current date
    $currentDate = Carbon::now()->format('Y-m-d');

    // Fetch data for MonthlyCollection (still using the current month)
    $monthlyCollections = MonthlyCollection::with('project:id,name')->get();


    // Fetch data for today's summary records
    $summaryDays = SummaryDay::whereDate('created_at', $currentDate)->get();

    $summaryInstallations = SummaryInstallation::whereDate('created_at', $currentDate)->get();

    $summaryPlanners = SummaryPlanner::whereDate('created_at', $currentDate)->get();

    // Fetch user tasks for today, excluding users with IDs 1, 2, 3
    $userTasks = Task::with('assignee:id,name')
        ->whereDate('due_date', $currentDate)
        ->whereNotIn('assigned_to', [1, 2, 3])
        ->get()
        ->groupBy('assignee.name'); // Group tasks by user name

    // Prepare data for the view
    $data = [
        'monthlyCollections' => $monthlyCollections,
        'summaryDays' => $summaryDays,
        'summaryInstallations' => $summaryInstallations,
        'summaryPlanners' => $summaryPlanners,
        'userTasks' => $userTasks, // Add user tasks to the data array
    ];

    // Create an instance of MPDF
    $mpdf = new \Mpdf\Mpdf([
        'default_font' => 'dejavusans',
        'mode' => 'utf-8',
        'format' => 'A4',
        'directionality' => 'rtl'
    ]);

    // Load HTML content with inline CSS for RTL support
    $html = view('daily_summary_pdf_template', compact('data'))->render();

    // Write the HTML content to the PDF
    $mpdf->WriteHTML($html);

    // Save the PDF to a file
    $pdfFilePath = storage_path('app/public/daily_summary_' . $currentDate . '.pdf');
    $mpdf->Output($pdfFilePath, 'F');

    // Send email with the PDF as an attachment
    Mail::send([], [], function ($message) use ($pdfFilePath, $currentDate) {
        $message->to(['eranlips@gmail.com', 'nitsanrozen01@gmail.com', 'amidierez@gmail.com', 'niramidi@gmail.com'])
                ->subject('סיכום יומי - ' . $currentDate)
                ->attach($pdfFilePath);
    });

    return response()->json(['message' => 'Daily PDF generated and sent to email successfully.']);
}
   

public function generateWeeklyPdfAndSendEmail(Request $request)
{
    // Get the current date and the date 4 days ago
    $currentDate = Carbon::now()->format('Y-m-d');
    $startDate = Carbon::now()->subDays(4)->format('Y-m-d');

    // Fetch data for MonthlyCollection (still using the current month)
    $monthlyCollections = MonthlyCollection::with('project:id,name')->get();

    // Fetch data for this week's summary records (last 5 days)
    $summaryDays = SummaryDay::whereBetween('created_at', [$startDate, $currentDate])->get();

    $summaryInstallations = SummaryInstallation::whereBetween('created_at', [$startDate, $currentDate])->get();

    $summaryPlanners = SummaryPlanner::whereBetween('created_at', [$startDate, $currentDate])->get();

    // Fetch user tasks for this week, excluding users with IDs 1, 2, 3
    $userTasks = Task::with('assignee:id,name')
        ->whereBetween('due_date', [$startDate, $currentDate])
        ->whereNotIn('assigned_to', [1, 2, 3])
        ->get()
        ->groupBy('assignee.name'); // Group tasks by user name

    // Prepare data for the view
    $data = [
        'monthlyCollections' => $monthlyCollections,
        'summaryDays' => $summaryDays,
        'summaryInstallations' => $summaryInstallations,
        'summaryPlanners' => $summaryPlanners,
        'userTasks' => $userTasks, // Add user tasks to the data array
    ];

    // Create an instance of MPDF
    $mpdf = new \Mpdf\Mpdf([
        'default_font' => 'dejavusans',
        'mode' => 'utf-8',
        'format' => 'A4',
        'directionality' => 'rtl'
    ]);

    // Load HTML content with inline CSS for RTL support
    $html = view('weekly_summary_pdf_template', compact('data'))->render();

    // Write the HTML content to the PDF
    $mpdf->WriteHTML($html);

    // Save the PDF to a file
    $pdfFilePath = storage_path('app/public/weekly_summary_' . $currentDate . '.pdf');
    $mpdf->Output($pdfFilePath, 'F');

    // Send email with the PDF as an attachment
    Mail::send([], [], function ($message) use ($pdfFilePath, $currentDate) {
        $message->to(['eranlips@gmail.com', 'nitsanrozen01@gmail.com', 'amidierez@gmail.com', 'niramidi@gmail.com'])
                ->subject('סיכום שבועי - ' . $currentDate)
                ->attach($pdfFilePath);
    });

    return response()->json(['message' => 'Weekly PDF generated and sent to email successfully.']);
}

public function generateDailyCollectionPdfAndSendEmail()
{
    // SQL command to fetch the relevant project collection data
    $projectCollections = DB::select('
        SELECT company_name, debt, project_name, last_invoice_issuance_date, retention_5, contact_person, payment_status, project_manager_mobile
        FROM collections
        WHERE have_problem IS NOT NULL;


    ');

    // Prepare data for the view
    $data = [
        'projectCollections' => $projectCollections
    ];

    // Create an instance of MPDF
    $mpdf = new Mpdf([
        'default_font' => 'dejavusans',
        'mode' => 'utf-8',
        'format' => 'A4',
        'directionality' => 'rtl'
    ]);

    // Load HTML content with inline CSS for RTL support
    $html = view('daily_collection_pdf_template', compact('data'))->render();

    // Write the HTML content to the PDF
    $mpdf->WriteHTML($html);

    // Save the PDF to a file
    $currentDate = Carbon::now()->format('Y-m-d');
    $pdfFilePath = storage_path('app/public/daily_collection_' . $currentDate . '.pdf');
    $mpdf->Output($pdfFilePath, 'F');

    // Send email with the PDF as an attachment
    Mail::send([], [], function ($message) use ($pdfFilePath, $currentDate) {
        $message->to(['eranlips@gmail.com', 'nitsanrozen01@gmail.com', 'amidierez@gmail.com', 'niramidi@gmail.com'])
                ->subject('סיכום יומי - גבייה לפרויקטים')
                ->attach($pdfFilePath);
    });

    return response()->json(['message' => 'Daily collection PDF generated and sent to email successfully.']);
}

public function generateAccountDetailsHtml(Request $request)
{
    $data = $request->all();

    // Render the HTML content
    $html = view('account_details_pdf_template', compact('data'))->render();

    return response()->json(['html' => $html]);
}


}
