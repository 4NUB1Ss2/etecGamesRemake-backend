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

Route::apiResource('schools', SchoolController::class)->except(['store', 'update', 'destroy']);
Route::apiResource('users', UserController::class)->except(['store', 'update', 'destroy']);
Route::apiResource('games', GameController::class)->except(['store', 'update', 'destroy', 'show']);
Route::get('games/{slug}', [GameController::class, 'show']);
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('auth/google', [AuthController::class, 'googleLogin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('schools', SchoolController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('users', UserController::class)->only(['store', 'destroy']);
    Route::put('users', [UserController::class, 'update']);
    Route::apiResource('games', GameController::class)->only(['store', 'update', 'destroy']);
    Route::get('me', [AuthController::class, 'me']);

});

