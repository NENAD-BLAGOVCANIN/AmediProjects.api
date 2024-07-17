<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $notifications = User::find($userId)->notifications()->paginate(20);

        return response()->json($notifications);
    }

    public function show($id)
    {
        $userId = auth()->user()->id;
        $notification = User::find($userId)->notifications()->findOrFail($id);
        return response()->json($notification);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $userId = auth()->user()->id;
        $notification = new Notification($validatedData);
        $notification->user_id = $userId;
        $notification->save();

        return response()->json($notification, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string',
        ]);

        $userId = auth()->user()->id;
        $notification = User::find($userId)->notifications()->findOrFail($id);
        $notification->update($validatedData);

        return response()->json($notification);
    }

    public function destroy($id)
    {
        $userId = auth()->user()->id;
        $notification = User::find($userId)->notifications()->findOrFail($id);
        $notification->delete();

        return response()->json(null, 204);
    }
}
