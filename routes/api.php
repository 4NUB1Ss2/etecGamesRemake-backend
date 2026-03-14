<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::apiResource('schools', SchoolController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('games', GameController::class);

