<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SummaryDay;
use App\Models\SummaryInstallation;
use App\Models\SummaryPlanner;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getStats(Request $request)
    {
        // Get the current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Retrieve records created in the current month
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
            "summaryDays" => $summaryDays, // Records created this month in SummaryDay
            "summaryInstallations" => $summaryInstallations, // Records created this month in SummaryInstallation
            "summaryPlanners" => $summaryPlanners, // Records created this month in SummaryPlanner
        ];

        return response()->json($data);
    }
}
