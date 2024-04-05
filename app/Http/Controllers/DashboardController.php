<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lead;
use App\Models\Task;
use App\Models\Contact;

class DashboardController extends Controller
{
    public function getStats(Request $request){

        $project_id = auth()->user()->currently_selected_project_id;

        $projectMemberCount = User::where('currently_selected_project_id', '=', $project_id)->count();
        $contactCount = Contact::where('project_id', '=', $project_id)->count();
        $leadCount = Lead::where('project_id', '=', $project_id)->count();
        $taskCount = Task::where('project_id', '=', $project_id)->count();
        $todoTasksCount = Task::where('project_id', '=', $project_id)->where('status', '=', Task::STATUS_TODO)->count();
        $inProgressTasksCount = Task::where('project_id', '=', $project_id)->where('status', '=', Task::STATUS_IN_PROGRESS)->count();
        $doneTasksCount = Task::where('project_id', '=', $project_id)->where('status', '=', Task::STATUS_DONE)->count();

        $data = [
            "projectMembersCount" => $projectMemberCount,
            "contactCount" => $contactCount,
            "leadCount" => $leadCount,
            "taskCount" => $taskCount,
            "todoTasksCount" => $todoTasksCount,
            "inProgressTasksCount" => $inProgressTasksCount,
            "doneTasksCount" => $doneTasksCount
        ];

        return response()->json($data);

    }
}
