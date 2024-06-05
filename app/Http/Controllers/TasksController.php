<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Helpers\NotificationHelper;
use App\Models\User;

class TasksController extends Controller
{
    public function index()
    {
        $tasks = Task::with('assignee')->where('project_id', '=', auth()->user()->currently_selected_project_id)->orderBy('id', 'desc')->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string',
            'description' => 'nullable|string',
            'lead_id' => 'nullable|exists:leads,id',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::create($validatedData);
        $task->project_id = auth()->user()->currently_selected_project_id;
        $task->status = Task::STATUS_TODO;
        $task->save();

        return response()->json($task, 201);
    }

    public function assign(Request $request){

        $user_id = $request->get('user_id');
        $user = User::findOrFail($user_id);

        $task_id = $request->get('task_id');

        $task = Task::findOrFail($task_id);
        $task->assigned_to = $user_id;
        $task->save();

        $updatedTask = Task::with('assignee')->findOrFail($task_id);

        $notificationTitle = "You have a new task.";
        $notificationBody = "Hello! Someone just assigned a new task to you. Go to the tasks page to check it out.";

        NotificationHelper::createNotificationForUser($user, $notificationTitle, $notificationBody);


        return response()->json($updatedTask, 201);
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string',
            'description' => 'nullable|string',
            'lead_id' => 'nullable|exists:leads,id',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'due_date' => 'nullable|date',
            'status' => 'required|string',
        ]);

        $task = Task::findOrFail($id);
        $task->update($validatedData);

        return response()->json($task, 200);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }
}
