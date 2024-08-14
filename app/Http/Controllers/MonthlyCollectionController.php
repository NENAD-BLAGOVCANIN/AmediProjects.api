<?php

namespace App\Http\Controllers;

use App\Models\MonthlyCollection;
use Illuminate\Http\Request;

class MonthlyCollectionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer',
            'amount_collected' => 'required|numeric'
        ]);

        $collection = MonthlyCollection::create($request->all());

        return response()->json($collection, 201);
    }

    public function index()
    {
        return MonthlyCollection::all();
    }

    public function show($id)
    {
        $collections = MonthlyCollection::where('project_id', $id)->get();
        return response()->json($collections);
    }

    public function update(Request $request, $id)
    {
        $collection = MonthlyCollection::findOrFail($id);

        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer',
            'amount_collected' => 'required|numeric'
        ]);

        $collection->update($request->all());

        return response()->json($collection);
    }

    public function getAmountCollectedThisMonth()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');

        $amountCollected = MonthlyCollection::where('month', $currentMonth)
            ->where('year', $currentYear)
            ->sum('amount_collected');

        return response()->json(['amount_collected' => $amountCollected]);
    }
}
