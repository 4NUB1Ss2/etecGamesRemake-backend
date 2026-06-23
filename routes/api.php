<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


Route::apiResource("schools", SchoolController::class)->except([
    "store",
    "update",
    "destroy",
]);
Route::apiResource("users", UserController::class)->except([
    "store",
    "update",
    "destroy",
]);
Route::apiResource("games", GameController::class)->except([
    "store",
    "update",
    "destroy",
    "show",
]);
Route::get("games/{slug}", [GameController::class, "show"]);
Route::post('games/{slug}/click', [GameController::class, 'increaseClick']);
Route::post("login", [AuthController::class, "login"]);
Route::post("register", [AuthController::class, "register"]);
Route::post("register-etec", [AuthController::class, "registerEtec"]);
Route::post("auth/google", [AuthController::class, "googleLogin"]);
Route::get("ping", [AuthController::class, "ping"]);
Route::post("emailtest/{username}", [AuthController::class, "emailTest"]);

Route::middleware("auth:sanctum")->group(function () {
    Route::apiResource("schools", SchoolController::class)->only([
        "store",
        "update",
        "destroy",
    ]);
    Route::apiResource("users", UserController::class)->only([
        "store",
        "destroy",
    ]);
    Route::put("users", [UserController::class, "update"]);
    Route::apiResource("games", GameController::class)->only([
        "store",
        "update",
        "destroy",
    ]);
    Route::get("me", [AuthController::class, "me"]);
    Route::post("auth/verify-email", [AuthController::class, "verifyEmail"]);
    Route::post("auth/resend-otp", [AuthController::class, "resendOtp"]);
});

Route::middleware(['auth:sanctum', 'IsProfessor'])->prefix('professor')->group(function () {
    Route::get('/approvals', [AdminController::class, 'studentApprovals']);
    Route::patch('/approvals/{usernae}', [AdminController::class, 'approveStudent']);

});


Route::middleware(['auth:sanctum', 'IsAdmin'])->prefix('admin')->group(function () {
    Route::get('/users', [AdminController::class, 'users']);
    Route::patch('/users/{username}', [AdminController::class, 'updateUser']);
    Route::get('/approvals', [AdminController::class, 'approvals']);

    Route::get('/games', [AdminController::class, 'games']);
    Route::patch('/games/{slug}', [AdminController::class, 'updateGame']);
    Route::delete('/games/{slug}', [AdminController::class, 'deleteGame']);

    Route::get('/schools', [AdminController::class, 'schools']);
    Route::post('/schools', [AdminController::class, 'createSchool']);
    Route::patch('/schools/{id}', [AdminController::class, 'updateSchool']);
    Route::delete('schools/{id}', [AdminController::class, 'deleteSchool']);

    //Route::post('/approvals', [AdminController::class, ''])

});
