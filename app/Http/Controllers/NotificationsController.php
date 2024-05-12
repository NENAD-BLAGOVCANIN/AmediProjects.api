<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $notifications = $user->notifications()->paginate(20);

        return response()->json($notifications);
    }
}
