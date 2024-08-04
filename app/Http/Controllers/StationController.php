<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StationController extends Controller
{
    // Fetch all stations
    public function index()
    {
        $stations = Station::with('projects')->get();

        $result = [];
        foreach ($stations as $station) {
          $result["stations"] = $stations;
            foreach ($station->projects as $project) {
                $result[] = [
                    // 'all_stations'=>$stations,
                    'project_id' => $project->id,
                    'project_name' => $project->name,
                    'station_id' => $station->id,
                    'station_name' => $station->name,
                    'entry_time' => $project->pivot->entry_time,
                    'due_date' => $project->pivot->due_date,
                ];
            }
        }

        return response()->json($result);
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
            return response()->json(['message' => 'Record not found or update failed'], 404);
        }
    }
}
