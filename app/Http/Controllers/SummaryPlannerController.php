<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SummaryPlanner;

class SummaryPlannerController extends Controller
{
    public function index()
    {
        return SummaryPlanner::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_name' => 'required|string',
            'date' => 'nullable|date',
            'worker_name' => 'nullable|string',
            'bonuses' => 'nullable|json',
        ]);

        return SummaryPlanner::create($request->all());
    }

    public function show($id)
    {
        return SummaryPlanner::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'project_name' => 'required|string',
            'date' => 'nullable|date',
            'worker_name' => 'nullable|string',
            'bonuses' => 'nullable|json',
        ]);

        $summaryPlanner = SummaryPlanner::findOrFail($id);
        $summaryPlanner->update($request->all());

        return $summaryPlanner;
    }

    public function destroy($id)
    {
        $summaryPlanner = SummaryPlanner::findOrFail($id);
        $summaryPlanner->delete();

        return response()->noContent();
    }
}
