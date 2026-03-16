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
