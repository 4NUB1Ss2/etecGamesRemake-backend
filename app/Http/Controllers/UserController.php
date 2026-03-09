<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $users = User::all();
            return Response()->json([
                "users" => $users,
            ],200);
        }catch (\Exception $exception){
            return Response()->json([
                'message' => "Nenhum Usúario encontrado",
            ],400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = User::create([
                ...$request->validated(),
                'password' => Hash::make($request->password),
                'role' => 'user',
            ]);

            return Response()->json([
                'user' => $user,

            ], 201);
        }catch (\Exception $exception){
            return Response()->json([
                'message' => 'erro ao cadastrar usuario',
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
//        $school_id = $request->school_id;
//        if ($school_id) {
//            $users = User::with('school')->where('school_id', $school_id)->get();
//            $school = School::findOrFail($school_id);
//
//            return Response()->json([
//                'users' => $users->map(function ($users) {
//                    return [
//                        'id' => $users->id,
//                        'username' => $users->username,
//                        'email' => $users->email,
//                        'nome' => $users->name,
//
//                    ];
//                }),
//                'school' => $school,
//            ]);
//        }
        try {
            $users = User::findOrFail($id);
            $school_id = $users->school_id;
            $school = School::findOrFail($school_id);
            return Response()->json([
                'users' => $users,
                'school' => $school,
            ], 200);
        } catch (\Exception $exception) {
            return Response()->json([
                'message' => "Nenhum Usuario encontrado",
            ], 400);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function hashtest(Request $request)
    {
        $password = $request->password;
        $id = $request->id;
        $user = User::findOrFail($id);
        $hashedPassword = $user->password;
        $verify = password_verify($password, $hashedPassword);

        return Response()->json([
            'message' => $verify,
        ]);

    }
}
