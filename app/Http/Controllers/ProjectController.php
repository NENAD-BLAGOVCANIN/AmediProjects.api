<?php

namespace App\Http\Controllers;

use App\Models\ProjectUser;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Production;
use App\Models\Collection;
use App\Models\Station;
use App\Models\ProjectProduct;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('users')->get();
        return response()->json($projects);
    }

    public function myProjects(Request $request)
    {
        $user = auth()->user();

        $projects = Project::with('users')->whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric',
            'accounting_phone' => 'nullable|string|max:255',
            'accounting_manager_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'company_number' => 'nullable|string|max:255',
            'project_manager_name' => 'nullable|string|max:255',
            'project_manager_phone' => 'nullable|string|max:255',
            'project_manager_email' => 'nullable|email|max:255',
            'contact_person' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file_url' => 'nullable|string|max:255',
            'products' => 'nullable|array',
        ]);
    
        $project = Project::create($validatedData);
    
        // Create a new collection entry
        Collection::create([
            'project_id' => $project->id,
            'company_name' => $project->company_name,
            'project_name' => $project->name,
            'contact_person' => $project->contact_person,
            'project_manager_mobile' => $project->project_manager_phone,
            'email' => $project->project_manager_email,
            'accounting_manager_mobile' => $project->accounting_phone,
        ]);
    
        // Create a new production entry
        Production::create([
            'project_id' => $project->id,
            'company' => $project->company_name,
            'site_city' => $project->location,
        ]);
          // Create a new station entry
          if ($request->filled('station_id')) {
            $station = Station::find($request->station_id);

            if ($station) {
                // Create a new entry in the pivot table
                $project->stations()->attach($station->id, [
                    'entry_time' => now(),
                    'due_date' => now()->addWeek(),
                    // other pivot fields
                ]);
            } else {
                // Handle the case where the station ID is invalid
                return response()->json(['error' => 'Invalid station ID'], 404);
            }
        }
        // Generate a notification
        $notificationTitle = 'New Project Created';
        $notificationBody = "A new project named '{$project->name}' has been created.";
        Notification::create([
            'title' => $notificationTitle,
            'body' => $notificationBody,
            'user_id' => auth()->id(), // assuming the user is authenticated
        ]);
    
        return response()->json($project, 201);
    }
    public function getProjectsStartedPerMonth()
{
    $projects = Project::selectRaw('MONTH(created_at) as month, COUNT(*) as projects_started')
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->get();

    return response()->json($projects);
}

    public function switchProject(Request $request)
    {
        $project_id = $request->get('project_id');
        $user = auth()->user();

        $user->currently_selected_project_id = $project_id;
        $user->save();

        return response()->json("Success");
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }

    public function projectInfo(Request $request)
    {
        $user = auth()->user();
        $project = Project::findOrFail($user->currently_selected_project_id);
        return response()->json($project);
    }

    public function update(Request $request)
    {
        $project_id = $request->get('id');
        $project = Project::findOrFail($project_id);

        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'company_name' => 'nullable|string',
            'location' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'phone' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'company_number' => 'nullable|string',
            'accounting_phone' => 'nullable|string',
            'project_manager_phone' => 'nullable|string',
            'accounting_email' => 'nullable|string',
            'project_manager_email' => 'nullable|string',
            'project_manager_name' => 'nullable|string',
            'accounting_manager_name' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('project_files', 'public');
            $validatedData['file_url'] = Storage::url($path);
        }

        $project->update($validatedData);

        return response()->json($project, 200);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(null, 204);
    }

    public function projectMembers(Request $request)
    {
        $project_id = auth()->user()->currently_selected_project_id;
        $project_members = ProjectUser::with('user')->where('project_id', '=', $project_id)->get();

        return response()->json($project_members, 200);
    }

    public function inviteLink(Request $request)
    {
        $user = auth()->user();
        $project_id = $request->get('project_id');
        $project = Project::findOrFail($project_id);
        $invite_code = $request->get('code');

        if ($invite_code == $project->invite_code) {
            $user->projects()->attach($project);
            $user->currently_selected_project_id = $project->id;
            $user->save();

            return response()->json("Success");
        } else {
            abort(403, 'Access denied.');
        }
    }

    public function getProjectDetails($id)
    {
        $project = Project::with(['collections', 'productions', 'products', 'stations'])->findOrFail($id);
        return response()->json($project);
    }

    
}
