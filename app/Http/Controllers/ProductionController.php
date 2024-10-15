<?php

namespace App\Http\Controllers;

use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\ProductionItem;
use Illuminate\Support\Arr;

class ProductionController extends Controller
{
    public function index()
    {
        // Load related items (not products)
        $productions = Production::with('items')->get(); 
        return response()->json($productions);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company' => 'required|string',
            'site_city' => 'nullable|string',
            'item' => 'nullable|string',
            'status' => 'nullable|string|in:new,planning,measuring,finished',
            'performed_by' => 'nullable|string',
            'notes' => 'nullable|string',
            'plan_id' => 'nullable|string',
            'fileUpload' => 'nullable|file|mimes:pdf|max:2048',
            'due_date' => 'nullable|date',
            'items' => 'array|min:1|max:10',
            'items.*.name' => 'required|string',  
            'items.*.type' => 'required|string',  
            'items.*.quantity' => 'required|integer|min:1',
            'urgency' => 'nullable|string|in:high,medium,low'
        ]);

        if (!isset($validatedData['urgency'])) {
            $validatedData['urgency'] = 'low';
        }

        if ($request->hasFile('fileUpload')) {
            $path = $request->file('fileUpload')->store('uploads', 'public');
            $validatedData['fileUpload'] = $path;
        }

        $production = Production::create($validatedData);

        foreach ($validatedData['items'] as $item) {
            ProductionItem::create([
                'production_id' => $production->id,
                'name' => $item['name'],
                'type' => $item['type'],
                'quantity' => $item['quantity'],
            ]);
        }

        return response()->json($production, 201);
    }

    public function show($id)
    {
        // Load related items (not products)
        $production = Production::with('items')->findOrFail($id); 
        return response()->json($production);
    }


    public function update(Request $request, $id)
    {
        Log::info('ProductionController update method called', ['id' => $id]);
        Log::info('Raw request data:', ['request' => $request->getContent()]);

    
        try {
            DB::beginTransaction();
    
            // Validate the incoming request data
            $validatedData = $request->validate([
                'company' => 'nullable|string',
                'project_id' => 'nullable|integer',
                'site_city' => 'nullable|string',
                'item' => 'nullable|string',
                'status' => 'nullable|string|in:new,planning,measuring,finished',
                'performed_by' => 'nullable|string',
                'notes' => 'nullable|string',
                'is_archive' => 'boolean',
                'plan_id' => 'nullable|string',
                'fileUpload' => 'nullable|file|mimes:pdf|max:2048',
                'due_date' => 'nullable|date',
                'items' => 'nullable|array',
                'items.*.name' => 'required_with:items|string',
                'items.*.type' => 'required_with:items|string',
                'items.*.quantity' => 'required_with:items|integer|min:1',
                'urgency' => 'nullable|string|in:high,medium,low'
            ]);
    
            Log::info('Validated Data:', $validatedData);
    
            $production = Production::findOrFail($id);
    
            if ($request->hasFile('fileUpload')) {
                $path = $request->file('fileUpload')->store('uploads', 'public');
                $validatedData['fileUpload'] = $path;
            }
    
            $production->update(Arr::except($validatedData, ['items']));
    
            Log::info('Production updated with data:', $production->fresh()->toArray());
    
            if (isset($validatedData['items'])) {
                Log::info('Updating items for production ID:', [$id]);
    
                ProductionItem::where('production_id', $production->id)->delete();
    
                foreach ($validatedData['items'] as $item) {
                    ProductionItem::create([
                        'production_id' => $production->id,
                        'name' => $item['name'],
                        'type' => $item['type'],
                        'quantity' => $item['quantity'],
                    ]);
                    Log::info('Inserted item:', $item);
                }
            } else {
                Log::info('No items provided for update');
            }
    
            DB::commit();
    
            return response()->json($production, 200);
        } catch (\Exception $e) {
            Log::error('Error updating production:', ['error' => $e->getMessage()]);
            DB::rollBack();
            return response()->json(['error' => 'Failed to update production', 'details' => $e->getMessage()], 500);
        }
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
        public function getFinishedPlansCount()
    {
        $count = Production::where('status', 'finished')->count();
        return response()->json(['finished_plans_count' => $count]);
    }
        public function getPlansOverFourDaysInPlanning()
    {
        $dateThreshold = Carbon::now()->subDays(4);
        $plans = Production::where('status', 'planning')
                    ->where('created_at', '<', $dateThreshold)
                    ->get();
        return response()->json(['plans_over_four_days' => $plans]);
    }


}
