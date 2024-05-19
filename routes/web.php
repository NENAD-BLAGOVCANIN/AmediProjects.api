<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/setTokenExpirationTimes', [AuthController::class, 'setTokenExpirationTimes']);