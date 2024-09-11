<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Helpers\NotificationHelper;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class TasksController extends Controller
{

    public function allTasksWithUsers()
    {
        $tasks = Task::with('assignee')->get(); // Assuming the relationship is called 'assignee'
        return response()->json($tasks);
    }
    public function updateArchiveStatus(Request $request, $id)
    {
        $validatedData = $request->validate([
            'is_archive' => 'required|boolean',
        ]);

        $task = Task::findOrFail($id);
        $task->is_archive = $validatedData['is_archive'];
        $task->save();

        return response()->json($task, 200);
    }
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
            'phone' => 'nullable|string',
            'email' => 'nullable|string',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'taskable_id' => 'nullable|integer',
            'taskable_type' => 'nullable|string|in:App\Models\Contact,App\Models\Collection,App\Models\Lead',
            'recurrence_type' => 'nullable|string|in:daily,weekly,monthly',
            'recurrence_end_date' => 'nullable|date|after:due_date',
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
        $task->status = Task::STATUS_IN_PROGRESS;

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

        if ($task->recurrence_type && $task->recurrence_end_date) {
            $this->generateRecurringTasks($task);
        }

        return response()->json($task, 201);
    }

    private function generateRecurringTasks(Task $task)
    {
        $currentDate = $task->due_date;
        $endDate = $task->recurrence_end_date;
        $recurrenceType = $task->recurrence_type;

        while ($currentDate < $endDate) {
            switch ($recurrenceType) {
                case 'daily':
                    $currentDate = $currentDate->addDay();
                    break;
                case 'weekly':
                    $currentDate = $currentDate->addWeek();
                    break;
                case 'monthly':
                    $currentDate = $currentDate->addMonth();
                    break;
            }

            if ($currentDate > $endDate) {
                break;
            }

            $newTask = $task->replicate();
            $newTask->due_date = $currentDate;
            $newTask->save();
        }
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

        // if ($request->filled('taskable_id') && $request->filled('taskable_type')) {
        //     $taskable = $validatedData['taskable_type']::find($validatedData['taskable_id']);
        //     if ($taskable) {
        //         $task->taskable_id = $validatedData['taskable_id'];
        //         $task->taskable_type = $validatedData['taskable_type'];
        //     } else {
        //         return response()->json(['error' => 'Invalid taskable ID or type'], 400);
        //     }
        // }

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

        Log::info('update tasks controller index method called', ["id"=>$id]);

        $validatedData = $request->validate([
            'subject' => 'nullable|string',
            'description' => 'nullable|string',
            'lead_id' => 'nullable|exists:leads,id',
            'assigned_to' => 'nullable|exists:users,id',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'due_date' => 'nullable|date',
            'status' => 'required|string',
        ]);
        Log::info('status before update', ['status' => $validatedData['status']]);

        // Set default description if not provided
        if (empty($validatedData['description'])) {
            $validatedData['description'] = 'אין תיאור';
        }

        $task = Task::findOrFail($id);
        Log::info('update tasks controller update method task',["task"=>$task]);
        $task->update($validatedData);
        Log::info('update tasks controller update method task updated',["updated"=>$task]);

        return response()->json($task, 200);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }



    public static function moveUnfinishedTasksToNextBusinessDay()
    {
        // Get current date and time
        $now = Carbon::now();
        
        // Find all tasks that are not done
        $unfinishedTasks = Task::whereIn('status', [Task::STATUS_IN_PROGRESS, Task::STATUS_ON_HOLD])
            ->where('due_date', '<=', $now)
            ->get();

        // Move them to the next business day
        foreach ($unfinishedTasks as $task) {
            $task->due_date = self::getNextBusinessDay($now);
            $task->save();
        }

        // Send summary email
        // self::sendDailySummaryEmail($unfinishedTasks);
    }

    private static function getNextBusinessDay($currentDate)
    {
        $nextBusinessDay = $currentDate->copy()->addDay();

        // Check if the next day is a weekend (Saturday or Sunday)
        while ($nextBusinessDay->isWeekend()) {
            $nextBusinessDay->addDay();
        }

        return $nextBusinessDay;
    }


}
