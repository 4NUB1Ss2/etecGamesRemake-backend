<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->credential)
            ->orWhere('username', $request->credential)
            ->first();
        if (!$user) {
            return response()->json([
                'message' => 'Wrong credentials'
            ],404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Wrong credentials'
            ],401);
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth')->plainTextToken;

        return response()->json([
            'token' => $token,
        ],200);






    }

    public function register(storeUserRequest $request){
        $user = User::create([
           ...$request->validated(),
           'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ],201);

    }

    public function me(Request $request) {
        return response()->json($request->user());
    }
}
