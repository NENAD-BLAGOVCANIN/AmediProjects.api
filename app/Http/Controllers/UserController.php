<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        return User::with('role')->orderBy('id', 'desc')->get();
    }

    public function store(Request $request)
    {
        return User::create($request->all());
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
    
    public function info(Request $request){

        $user = User::with('project')->find(auth()->id());

        return response()->json($user, 200);
    }
}
