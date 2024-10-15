<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StationController extends Controller
{
    // Fetch all stations
    public function index()
    {
        Log::info('StationController index method called');

        $stations = Station::with(['projects' => function ($query) {
            $query->select('projects.id', 'projects.name', 'projects.company_name', 'projects.project_manager_name')
                  ->orderBy('project_station.order');  // Order by the new 'order' column
        }])->get();

        $result = [];
        foreach ($stations as $station) {
            $stationData = [
                'station_id' => $station->id,
                'station_name' => $station->name,
                'projects' => []
            ];
    
            foreach ($station->projects as $project) {
                $stationData['projects'][] = [
                    'project_id' => $project->id,
                    'project_name' => $project->name,
                    'company_name' => $project->company_name,
                    'project_manager_name' => $project->project_manager_name,
                    'entry_time' => $project->pivot->entry_time,
                    'due_date' => $project->pivot->due_date,
                    'installer' => $project->pivot->installer,
                    'order' => $project->pivot->order,  // Include the order in the response
                ];
            }
    
            $result[] = $stationData;
        }
    
        return response()->json(['stations' => $result]);
    }
    

    // Store a new station
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Add other validation rules as needed
        ]);

        $station = Station::create($request->all());

        return response()->json($station, 201);
    }

    // Update an existing station
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            // Add other validation rules as needed
        ]);

        $station = Station::findOrFail($id);
        $station->update($request->all());

        return response()->json($station, 200);
    }

    // Delete a station
    public function destroy($id)
    {
        $station = Station::findOrFail($id);
        $station->delete();

        return response()->json(null, 204);
    }
    public function updateStation(Request $request, $project_id)
    {
        Log::info('StationController updateStation method called');

        // Validate the request
        $validatedData = $request->validate([
            'station_id' => 'required|integer|exists:stations,id',
        ]);
    
        // Find the record in the project_station table using project_id and update the station_id
        $affected = DB::table('project_station') // Make sure DB is imported
            ->where('project_id', $project_id)
            ->update(['station_id' => $validatedData['station_id']]);
    
        // Check if the update was successful
        if ($affected) {
            return response()->json(['message' => 'Station updated successfully'], 200);
        } else {
            return response()->json(['message' => 'אתה באותה תחנה' ], 200);
        }
    }

    public function updateProjectOrder(Request $request)
    {
        $validatedData = $request->validate([
            'project_id' => 'required|integer|exists:project_station,project_id',
            'station_id' => 'required|integer|exists:stations,id',
            'new_order' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($validatedData) {
            $projectId = $validatedData['project_id'];
            $newStationId = $validatedData['station_id'];
            $newOrder = $validatedData['new_order'];

            // Get current project information
            $currentProject = DB::table('project_station')
                ->where('project_id', $projectId)
                ->first();

            if ($currentProject->station_id != $newStationId) {
                // Project is moving to a new station
                // Decrease order of all projects in the old station with order > current order
                DB::table('project_station')
                    ->where('station_id', $currentProject->station_id)
                    ->where('order', '>', $currentProject->order)
                    ->decrement('order');

                // Increase order of all projects in the new station with order >= new order
                DB::table('project_station')
                    ->where('station_id', $newStationId)
                    ->where('order', '>=', $newOrder)
                    ->increment('order');

                // Update the project's station and order
                DB::table('project_station')
                    ->where('project_id', $projectId)
                    ->update([
                        'station_id' => $newStationId,
                        'order' => $newOrder
                    ]);
            } else {
                // Project is reordering within the same station
                if ($newOrder > $currentProject->order) {
                    // Moving down, decrease orders of projects between current and new
                    DB::table('project_station')
                        ->where('station_id', $newStationId)
                        ->whereBetween('order', [$currentProject->order + 1, $newOrder])
                        ->decrement('order');
                } else {
                    // Moving up, increase orders of projects between new and current
                    DB::table('project_station')
                        ->where('station_id', $newStationId)
                        ->whereBetween('order', [$newOrder, $currentProject->order - 1])
                        ->increment('order');
                }

                // Update the project's order
                DB::table('project_station')
                    ->where('project_id', $projectId)
                    ->update(['order' => $newOrder]);
            }

            // Normalize orders to ensure they are consecutive
            $this->normalizeOrders($newStationId);
        });

        return response()->json(['message' => 'Project order updated successfully'], 200);
    }

    private function normalizeOrders($stationId)
    {
        $projects = DB::table('project_station')
            ->where('station_id', $stationId)
            ->orderBy('order')
            ->get();

        foreach ($projects as $index => $project) {
            DB::table('project_station')
                ->where('project_id', $project->project_id)
                ->update(['order' => $index]);
        }
    }

}
