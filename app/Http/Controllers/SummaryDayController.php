<?php
namespace App\Http\Controllers;

use App\Models\SummaryDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SummaryDayController extends Controller
{
    public function index()
    {
        $summaryDays = SummaryDay::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        return response()->json($summaryDays);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'collected_today' => 'nullable|string',
            'future_collection' => 'nullable|string',
            'problems' => 'nullable|string',
        ]);

        $summaryDay = SummaryDay::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
            'collected_today' => $request->collected_today,
            'future_collection' => $request->future_collection,
            'problems' => $request->problems,
            'is_archive' => false,
        ]);

        return response()->json($summaryDay, 201);
    }

    public function show(SummaryDay $summaryDay)
    {
        if ($summaryDay->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($summaryDay);
    }

    public function update(Request $request, SummaryDay $summaryDay)
    {
        if ($summaryDay->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required|string',
            'collected_today' => 'nullable|string',
            'future_collection' => 'nullable|string',
            'problems' => 'nullable|string',
        ]);

        $summaryDay->update($request->all());

        return response()->json($summaryDay);
    }

    public function destroy(SummaryDay $summaryDay)
    {
        if ($summaryDay->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $summaryDay->delete();
        return response()->json(['message' => 'Summary day deleted successfully']);
    }

    
    public function getCollectionSummary()
    {
        $summaries = SummaryDay::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get(['collected_today', 'future_collection', 'problems', 'created_at']);
    
        return response()->json($summaries);
    }
    

}