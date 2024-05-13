<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(20);

        return response()->json($notifications);
    }

    public function show($id)
    {

        $notification = auth()->user()->notifications()->find($id)->firstOrFail();
        return response()->json($notification);
    }

}
