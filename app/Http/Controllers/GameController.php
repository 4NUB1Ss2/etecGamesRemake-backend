<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $games = Game::All();
            return Response()->json([
                'games' => $games
            ],200);
        }catch (\Exception $exception){
            return Response()->json([
                'message' => 'Nenhum registro encontrado!'
            ],400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameRequest $request)
    {
        try{
            if($request->hasfile('image')){

                $imagePath = $request->file('image')->store('gameimages', 'supabase');
            }

            $game = Game::create([
                ...$request->validated(),
                'image' => $imagePath,
                'clicks' => 10,
            ]);

            return Response()->json([
                ...$game->toArray(),
                'image' => $game->image ? Storage::disk('supabase')->url($game->image) : null
            ],200);

        }catch (\Exception $exception){

            return Response()->json([
//          'message' => 'Erro ao cadastrar registro!'
            'message' => $exception->getMessage()
            ],400);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $game = Game::findOrFail($id);

            return Response()->json([
                ...$game->toArray(),
                'image' => asset('storage/'.$game->image),
            ]);
        }catch (\Exception $exception){
            return Response()->json([
                'message' => $exception->getMessage()
            ]);
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
}
