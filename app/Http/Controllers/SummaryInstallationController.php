<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SummaryInstallation;

class SummaryInstallationController extends Controller
{
    public function index()
    {
        $summaryInstallations = SummaryInstallation::all();
        return response()->json($summaryInstallations);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'project_name' => 'required|string',
            'date' => 'nullable|date',
            'worker_name' => 'nullable|string',
            'bonuses' => 'nullable|json'
        ]);

        $summaryInstallation = SummaryInstallation::create($validatedData);
        return response()->json($summaryInstallation, 201);
    }

    public function show($id)
    {
        $summaryInstallation = SummaryInstallation::findOrFail($id);
        return response()->json($summaryInstallation);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'project_name' => 'required|string',
            'date' => 'nullable|date',
            'worker_name' => 'nullable|string',
            'bonuses' => 'nullable|json'
        ]);

        $summaryInstallation = SummaryInstallation::findOrFail($id);
        $summaryInstallation->update($validatedData);
        return response()->json($summaryInstallation);
    }

    public function destroy($id)
    {
        $summaryInstallation = SummaryInstallation::findOrFail($id);
        $summaryInstallation->delete();
        return response()->json(null, 204);
    }
}
