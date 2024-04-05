<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function info(Request $request){

        $user = User::with('project')->find(auth()->id());

        return response()->json($user, 200);
    }
}
