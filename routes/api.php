<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::apiResource('schools', SchoolController::class);
Route::get('users', [UserController::class, 'index']);
Route::apiResource('games', GameController::class);
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('users',  [UserController::class, 'store']);
    Route::put('users/{id}',  [UserController::class, 'update']);
    Route::delete('users/{id}',  [UserController::class, 'destroy']);
    Route::get('/me', [AuthController::class, 'me']);

});

