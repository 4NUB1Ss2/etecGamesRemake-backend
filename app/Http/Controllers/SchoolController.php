<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;


class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $schools = School::all();

        return Response()->json([
            'schools' => $schools
        ], 200);



    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchoolRequest $request)
    {
        try {
            $school = School::create($request->validated());
            return Response()->json([
                'school' => $school
            ], 201);
        }catch (\Exception $exception){
            return Response()->json([
                'message' => 'Erro ao cadastrar escola',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        try {
            $school = School::findOrFail($id);
            return Response()->json([
                'school' => $school
            ],200);
        }catch (\Exception $exception){
            return Response()->json([
                'message' => 'Erro ao carregar escola',
            ],400);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchoolRequest $request, string $id)
    {
        $school = School::findOrFail($id);
        $school->update($request->validated());

        return Response()->json([
            'school' => $school
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $removed = School::destroy($id);
            if  (!$removed){
                throw new \Exception();
            }
            return Response()->json(null, 204);
        }catch (\Exception $exception){
            return Response()->json([
                "message" => "Erro ao deletar escola",
            ],400);
        }
    }
}
