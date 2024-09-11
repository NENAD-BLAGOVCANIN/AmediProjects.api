<?php

namespace App\Http\Controllers;

use App\Models\MonthlyCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MonthlyCollectionController extends Controller
{
    public function store(Request $request)
    {
        Log::info('MonthlyCollectionController store method called', ['request_data' => $request->all()]);
    
        try {
            $request->validate([
                'project_id' => 'required|exists:projects,id',
                'month' => 'required|integer|min:1|max:12',
                'year' => 'required|integer',
                'is_archive' => 'nullable',
                'amount_collected' => 'required|numeric'
            ]);
    
            Log::info('Validation passed', ['request_data' => $request->all()]);
    
            $collection = MonthlyCollection::create($request->all());
    
            Log::info('Monthly collection created successfully', ['collection_data' => $collection]);
    
            return response()->json($collection, 201);
    
        } catch (ValidationException $e) {
            // Log the validation errors
            Log::error('Validation failed', ['errors' => $e->errors()]);
    
            // Optionally, you can return a custom error response
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log any other exception that may occur
            Log::error('An unexpected error occurred', ['exception' => $e->getMessage()]);
    
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function index()
    {
        return MonthlyCollection::with('project:id,name')->get();
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
            'is_archive' => 'nullable',
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
