<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
        return response()->json($request->user(),200);
    }

    public function googleLogin(Request $request)
{
    $request->validate(['token' => 'required|string']);

    $response = Http::get('https://www.googleapis.com/oauth2/v3/userinfo', [
        'access_token' => $request->token,
    ]);

    if (!$response->ok()) {
        return response()->json(['message' => 'Token inválido'], 401);
    }

    $payload = $response->json();

    $user = User::where('google_id', $payload['sub'])
                ->orWhere('email', $payload['email'])
                ->first();

    if ($user) {
        if (!$user->google_id) {
            $user->update(['google_id' => $payload['sub']]);
        }
    } else {
        $user = User::create([
            'name'              => $payload['name'],
            'email'             => $payload['email'],
            'username'          => $this->generateUsername($payload['email']),
            'password'          => Hash::make(Str::random(32)),
            'google_id'         => $payload['sub'],
            'email_verified_at' => now(),
            'role'              => 'user',
            'school_id'         => 1,
        ]);
    }

    return response()->json([
        'token' => $user->createToken('auth')->plainTextToken,
        'user'  => $user,
    ]);
}

private function generateUsername(string $email): string
{
    $base = str_replace(['.', '-', '_'], '', explode('@', $email)[0]);
    $base = preg_replace('/[^a-z0-9]/', '', strtolower($base));
    $username = $base;
    $i = 1;

    while (User::where('username', $username)->exists()) {
        $username = $base . $i;
        $i++;
    }

    return $username;

    
}
}
