<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SummaryDay;
use App\Models\SummaryInstallation;
use App\Models\SummaryPlanner;
use App\Models\Project;
use App\Models\Production;
use App\Models\Collection;
use App\Models\AccountDetail;
use App\Models\PriceOffers;
use App\Models\MonthlyCollection;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class DashboardController extends Controller
{

//     public function getWeeklyNewProjects()
// {
//     $count = Project::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
//     return response()->json(['weekly_new_projects' => $count]);
// }

    public function getStats(Request $request)
    {
        // Get the current date, month, and year
        $currentDate = Carbon::now();
        $currentMonth = $currentDate->month;
        $currentYear = $currentDate->year;

        // Get the start and end of the current week
        $startOfWeek = $currentDate->startOfWeek();
        $endOfWeek = $currentDate->endOfWeek();

        // 1. Number of new projects entered into the system this week
        $projectsThisWeek = Project::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

        // 2. Number of plans transferred to production (status is 'finished')
        $finishedPlans = Production::where('status', 'finished')->count();

        // 3. Number of plans in 'planning' status
        $planningPlans = Production::where('status', 'planning')->count();

        // 4. Amount of money collected this month
        $amountCollectedThisMonth = MonthlyCollection::where('month', $currentMonth)
            ->where('year', $currentYear)
            ->sum('amount_collected');

        // 5. Total amount of money that needs to be collected (total debt)
        $totalDebt = Collection::where('is_archive', 0)->sum('debt');

        // 6. Amount of money collected per month
        $amountCollectedPerMonth = MonthlyCollection::selectRaw('year, month, SUM(amount_collected) as total_collected')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Existing code to retrieve records for the current month
        $summaryDays = SummaryDay::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->get();

        $summaryInstallations = SummaryInstallation::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->get();

        $summaryPlanners = SummaryPlanner::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->get();

        // Compile all data into a single array
        $data = [
            "summaryDays" => $summaryDays,
            "summaryInstallations" => $summaryInstallations,
            "summaryPlanners" => $summaryPlanners,

            // New statistics
            "projectsThisWeek" => $projectsThisWeek,
            "finishedPlans" => $finishedPlans,
            "planningPlans" => $planningPlans,
            "amountCollectedThisMonth" => $amountCollectedThisMonth,
            "totalDebt" => $totalDebt,
            "amountCollectedPerMonth" => $amountCollectedPerMonth,
        ];

        return response()->json($data);
    }

    public function getWeeklyPriceOffers()
    {
        $count = PriceOffers::where('status', 'sent')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        return response()->json(['weekly_price_offers' => $count]);
    }

    public function getWeeklyNewProjects()
    {
        $count = Project::where('created_at', '>=', now()->startOfWeek())
            ->count();

        return response()->json(['weekly_new_projects' => $count]);
    }

    public function getPlansOverFourDays()
    {
        $count = Project::where('status', 'planning')
            ->where('updated_at', '<=', now()->subDays(4))
            ->count();

        return response()->json(['plans_over_four_days' => $count]);
    }

    public function getProjectsPerManager()
    {
        $projects = Project::with('users')
            ->select('project_manager_name', \DB::raw('count(*) as project_count'))
            ->groupBy('project_manager_name')
            ->get();

        // הנחה: יש לך שדה 'project_manager_name' או שאתה משתמש ביחסים כדי לקבל את השם
        return response()->json(['projects_per_manager' => $projects]);
    }

  // app/Http/Controllers/DashboardController.php

public function getAccountsPerManager()
{
    $accounts = AccountDetail::with('project.manager') // assuming 'manager' is defined
        ->select('project_id', DB::raw('sum(total) as total_accounts'))
        ->groupBy('project_id')
        ->get();

    // מיפוי הנתונים לשמות מנהלי הפרויקטים
    $result = $accounts->map(function($item) {
        return [
            'project_manager_name' => $item->project->manager->name ?? 'לא ידוע',
            'total_accounts' => $item->total_accounts,
        ];
    });

    return response()->json(['accounts_per_manager' => $result]);
}


    public function getAmountSentDetails()
    {
        $amount = AccountDetail::sum('total');

        return response()->json(['amount_sent_details' => $amount]);
    }

    public function getAccountDetailsSent()
    {
        $count = AccountDetail::whereNotNull('sent_at')->count(); // הנחה שיש שדה sent_at

        return response()->json(['account_details_sent' => $count]);
    }
    public function getCollectionTrends()
    {
        $data = Collection::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(collected_amount) as total_collected'))
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return response()->json(['collection_trends' => $data]);
    }
      // פונקציה לקבלת פירוט גבייה (לדוגמה: פירוט לפי סוג תשלום)
      public function getCollectionBreakdown()
      {
          $data = Collection::select('payment_status', DB::raw('COUNT(*) as count'))
              ->groupBy('payment_status')
              ->get();
  
          return response()->json(['collection_breakdown' => $data]);
      }
}
