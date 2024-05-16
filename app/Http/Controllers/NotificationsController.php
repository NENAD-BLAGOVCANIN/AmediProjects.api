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
        $notification = User::find($userId)->notifications()->find($id)->firstOrFail();
        return response()->json($notification);
    }

}
