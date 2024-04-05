<?php

namespace App\Http\Controllers;

use App\Models\ProjectUser;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return response()->json($projects);
    }

    public function myProjects(Request $request)
    {
        $user = auth()->user();

        $projects = Project::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $user = auth()->user();

        $project = Project::create($validatedData);
        $project->save();

        $user->currently_selected_project_id = $project->id;
        $user->save();
        $user->projects()->attach($project);

        return response()->json($project, 201);
    }

    public function switchProject(Request $request){
        
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

    public function projectInfo(Request $request){
        $user = auth()->user();
        $project = Project::findOrFail($user->currently_selected_project_id);
        return response()->json($project);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $user = auth()->user();

        $project = Project::findOrFail($user->currently_selected_project_id);
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

    public function inviteLink(Request $request){

        $user = auth()->user();
        $project_id = $request->get('project_id');
        $project = Project::findOrFail($project_id);
        $invite_code = $request->get('code');

        if ($invite_code == $project->invite_code){
            $user->projects()->attach($project);
            $user->currently_selected_project_id = $project->id;
            $user->save();

            return response()->json("Success");

        }else{
            abort(403, 'Access denied.');
        }

    }

}
