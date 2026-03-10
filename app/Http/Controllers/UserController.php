<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
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
            ],400);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
//
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
    public function update(UpdateUserRequest $request, string $id)
    {

        try {
            $user = User::findOrFail($id);
            $user->update([
                ...$request->validated(),
                'password' => Hash::make($request->password),

            ]);

            return Response()->json([
                'user' => $user,
            ], 200);
        } catch (\Exception $exception) {
            return Response()->json([
                'message' => "Nenhum Usuario encontrado",
            ], 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $removed = User::destroy($id);
            if (!$removed)
            {
                throw new \Exception();
            }
            return Response()->json(null, 204);
        }catch (\Exception $exception){
            return Response()->json([
                'message' => "Nenhum Usuario encontrado",
            ],400);
        }
    }

}
