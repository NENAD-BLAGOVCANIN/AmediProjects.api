<?php

namespace App\Http\Controllers;

use App\Models\Production;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index()
    {
        $productions = Production::all();
        return response()->json($productions);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company' => 'required|string',
            'site_city' => 'nullable|string',
            'item' => 'nullable|string',
            'status' => 'nullable|string|in:planning,measuring,finished',
            'performed_by' => 'nullable|string',
            'notes' => 'nullable|string',
            'plan_id' => 'nullable|string',
            'fileUpload' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        // Set default status if not provided
        if (!isset($validatedData['status'])) {
            $validatedData['status'] = 'measuring';
        }

        // Set is_archive to false by default
        $validatedData['is_archive'] = false;

        $production = Production::create($validatedData);

        return response()->json($production, 201);
    }

    public function show($id)
    {
        $production = Production::findOrFail($id);
        return response()->json($production);
    }

    public function update(Request $request, $id)
    {
        $production = Production::findOrFail($id);

        $validatedData = $request->validate([
            'company' => 'required|string',
            'site_city' => 'nullable|string',
            'item' => 'nullable|string',
            'status' => 'nullable|string|in:planning,measuring,finished',
            'performed_by' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_archive' => 'boolean',
            'plan_id' => 'nullable|string',
            'fileUpload' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        // Set default status if not provided
        if (!isset($validatedData['status'])) {
            $validatedData['status'] = 'measuring';
        }

        $production->update($validatedData);

        return response()->json($production, 200);
    }

    public function destroy($id)
    {
        $production = Production::findOrFail($id);
        $production->is_archive = true;
        $production->save();

        return response()->json(['message' => 'Production archived successfully']);
    }

    public function getActivePlanningProductions()
{
    $activePlannings = Production::where('status', 'planning')->count();

    return response()->json(['active_plannings' => $activePlannings]);
}
}
