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
        $tasks = Task::with('assignee')
        ->where('assigned_to', auth()->id())
        ->orderBy('id', 'desc')
        ->get();
    return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subject' => 'nullable|string',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'taskable_id' => 'nullable|integer',
            'taskable_type' => 'nullable|string|in:App\Models\Contact,App\Models\Collection,App\Models\Lead',
        ]);
      // Set default description if not provided
      if (empty($validatedData['description'])) {
        $validatedData['description'] = 'אין תיאור';

        }
        // Ensure assigned_to is not null
        if (empty($validatedData['assigned_to'])) {
            $validatedData['assigned_to'] = auth()->id();
        }
        $task = new Task($validatedData);
        $task->project_id = auth()->user()->currently_selected_project_id;
        $task->status = Task::STATUS_TODO;
    
        if ($request->filled('taskable_id') && $request->filled('taskable_type')) {
            $taskable = $request->input('taskable_type')::find($request->input('taskable_id'));
            if ($taskable) {
                $taskable->tasks()->save($task);
            } else {
                return response()->json(['error' => 'Invalid taskable ID or type'], 400);
            }
        } else {
            $task->save();
        }
    
        return response()->json($task, 201);
    }
    public function getTaskableItems(Request $request)
{
    $request->validate([
        'taskable_type' => 'required|string|in:App\\Models\\Contact,App\\Models\\Collection,App\\Models\\Lead',
    ]);

    $taskableType = $request->input('taskable_type');
    $items = $taskableType::select('id', 'name')->get(); // Adjust the select fields as necessary

    return response()->json($items);
}


public function assign(Request $request)
{
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id',
        'task_id' => 'required|exists:tasks,id',
        'taskable_id' => 'nullable|integer',
        'taskable_type' => 'nullable|string|in:App\Models\Contact,App\Models\Collection,App\Models\Lead',
    ]);

    $task = Task::findOrFail($validatedData['task_id']);
    $task->assigned_to = $validatedData['user_id'];
    $task->project_id = $validatedData['project_id'] ?? $task->project_id;

    if ($request->filled('taskable_id') && $request->filled('taskable_type')) {
        $taskable = $validatedData['taskable_type']::find($validatedData['taskable_id']);
        if ($taskable) {
            $task->taskable_id = $validatedData['taskable_id'];
            $task->taskable_type = $validatedData['taskable_type'];
        } else {
            return response()->json(['error' => 'Invalid taskable ID or type'], 400);
        }
    }

    $task->save();

    $user = User::findOrFail($validatedData['user_id']);
    $notificationTitle = "You have a new task.";
    $notificationBody = "Hello! Someone just assigned a new task to you. Go to the tasks page to check it out.";

    NotificationHelper::createNotificationForUser($user, $notificationTitle, $notificationBody);

    return response()->json($task->load('assignee'), 201);
}

    

    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'subject' => 'nullable|string',
            'description' => 'nullable|string',
            'lead_id' => 'nullable|exists:leads,id',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'due_date' => 'nullable|date',
            'status' => 'required|string',
        ]);
        // Set default description if not provided
        if (empty($validatedData['description'])) {
            $validatedData['description'] = 'אין תיאור';
        }
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
