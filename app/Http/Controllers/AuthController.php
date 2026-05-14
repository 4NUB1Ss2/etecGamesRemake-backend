<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\storeUserEtecRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Resend\Laravel\Facades\Resend;
use Spatie\OneTimePasswords\Enums\ConsumeOneTimePasswordResult;

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

        if ($user->banned) {
            return response()->json(['message' => 'Sua conta foi suspensa'],403);
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ],200);

        
    }

    public function ping(Request $request){
        return response()->json([
        'message' => 'ok'
        ], 200);
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

    public function registerEtec(storeUserEtecRequest $request){

        $user = User::create([
           ...$request->validated(),
           'password' => Hash::make($request->password),
           'verified' => false,
        ]);

        $token = $user->createToken('auth')->plainTextToken;

        $OTP = $user->createOneTimePassword();
        $cod = $OTP->password;

        Resend::emails()->send([
            'from'     => 'Support <support@etecgames.com.br>',
            'to'       => $user->email,
            'subject'  => 'Seu código de verificação — ETECGames',
            'reply_to' => 'giovanni.4nub1s@gmail.com',
            'html'     => view('emails.verify', ['otp' => $cod, 'user' => $user])->render(),
        ]);

        return response()->json([
            'user' => $user,
            'token' => $token,
        ],201);
        
    }

    public function verifyEmail(Request $request) {

        
        if (!$request->otp)
        {
            return response()->json([
                'message' => 'A request não tem um OTP válido.',
            ],400);
        }
        
        
        $OTP = $request->otp;
        
        $user = $request->user();
        if (!$user)
        {
            return response()->json([
                'message' => 'Usuário não encontrado.',
            ],404);
        }
        $result = $user->consumeOneTimePassword($OTP);

        if ($result->isOk())
        {
            $user->update(['verified' => true]);
            return response()->json([
                'message' => 'E-Mail verificado.',
            ],200);
        }

        dd($result->name, get_class($result));

        if ($result->isNoOneTimePasswordsFound()){
            return response()->json(['message' => 'Nenhum código OTP foi gerado para esse usuário.'],400);
        }
        if ($result->isIncorrectOneTimePassword()){
            return response()->json(['message' => 'O código OTP informado está incorreto.'],400);
        }
        if ($result->isDifferentOrigin()){
            return response()->json(['message' => 'O código OTP foi gerado em um dispositivo diferente.'],400);
        }
        if ($result->isOneTimePasswordExpired()){
            return response()->json(['message' => 'O código OTP expirou'],400);
        }
        if ($result->isRateLimitExceeded()){
            return response()->json(['message' => 'Rate limit excedido.'],400);
        }

        return response()->json([
            'message' => 'Não foi possível validar o código OTP. Por favor tente novamente.'
        ],400);
        
    }

    public function me(Request $request) {
        return response()->json($request->user(),200);
    }

    public function resendOtp(Request $request) {
        $user = $request->user();

        $OTP = $user->createOneTimePassword();
        $cod = $OTP->password;

        Resend::emails()->send([
            'from'     => 'Support <support@etecgames.com.br>',
            'to'       => $user->email,
            'subject'  => 'Seu código de verificação — ETECGames',
            'reply_to' => 'giovanni.4nub1s@gmail.com',
            'html'     => view('emails.verify', ['otp' => $cod, 'user' => $user])->render(),
        ]);

        return response()->json(["message" => "Novo código OTP enviado"],200);
        
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

public function emailTest(Request $request, String $username)
{
    $user = User::where('username', $username)->firstOrFail();
    $OTP = 103921;
    Resend::emails()->send([
        'from'     => 'Support <support@etecgames.com.br>',
        'to'       => $user->email,
        'subject'  => 'Seu código de verificação — ETECGames',
        'reply_to' => 'giovanni.4nub1s@gmail.com',
        'html'     => view('emails.verify', ['otp' => $OTP, 'user' => $user])->render(),
    ]);

    return response()->json(['message' => 'Email enviado'],201);
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
