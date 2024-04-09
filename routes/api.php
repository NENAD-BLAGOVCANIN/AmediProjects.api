<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
});


Route::group(['middleware' => 'auth:api'], function () {

    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::put('users/{user}', [UserController::class, 'update']);
    Route::delete('users/{user}', [UserController::class, 'destroy']);
    Route::get('/user/info', [UserController::class, 'info']);


    Route::get('/contacts', [ContactsController::class, 'index']);
    Route::post('/contacts', [ContactsController::class, 'store']);
    Route::get('/contacts/{id}', [ContactsController::class, 'show']);
    Route::put('/contacts/{id}', [ContactsController::class, 'update']);
    Route::delete('/contacts/{id}', [ContactsController::class, 'destroy']);


    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/my-projects', [ProjectController::class, 'myProjects']);
    Route::get('/project-info', [ProjectController::class, 'projectInfo']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::post('/switch-project', [ProjectController::class, 'switchProject']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    Route::put('/project', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
    Route::get('/project/members', [ProjectController::class, 'projectMembers']);


    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);


    Route::get('/tasks', [TasksController::class, 'index']);
    Route::post('/tasks', [TasksController::class, 'store']);
    Route::post('/tasks/assign', [TasksController::class, 'assign']);
    Route::get('/tasks/{id}', [TasksController::class, 'show']);
    Route::put('/tasks/{id}', [TasksController::class, 'update']);
    Route::delete('/tasks/{id}', [TasksController::class, 'destroy']);


    Route::get('/leads', [LeadsController::class, 'index']);
    Route::post('/leads', [LeadsController::class, 'store']);
    Route::get('/leads/{id}', [LeadsController::class, 'show']);
    Route::put('/leads/{id}', [LeadsController::class, 'update']);
    Route::delete('/leads/{id}', [LeadsController::class, 'destroy']);

    Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);

});

Route::post('/handle-invite-link', [ProjectController::class, 'inviteLink']);
