<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $page = $request->input('current_page', 1);
            $section = $request->input('section', 'last');

            $query = Game::query();

            switch ($section) {
                case 'last':
                    $query->orderBy('games.created_at', 'desc');
                    break;
                case 'clicks':
                    $query->orderBy('games.clicks', 'desc');
                    break;
                default:
                    $query->orderBy('games.created_at', 'desc');
                    break;
            }
            $games = $query->paginate(3, ['*'], 'page', $page);

            return response()->json($games, 200);
        }catch (\Exception $exception){
            return response()->json([
                'error' => $exception->getMessage()
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

            return Response()->json($game,201);

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
                'image' => $game->image ? Storage::disk('supabase')->url($game->image) : null,
            ],200);
        }catch (\Exception $exception){
            return Response()->json([
                'message' => $exception->getMessage()
            ],400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameRequest $request, string $id)
    {
        try{

            if ($request->hasfile('image')) {
                $imagePath = $request->file('image')->store('gameimages', 'supabase');

            }
            if ($imagePath) {

                $game = Game::findOrFail($id);
                $game->update([
                    ...$request->validated(),
                    'image' => $imagePath,
                ]);
            }
            else {
                $game = Game::findOrFail($id);
                $game->update([$request->validated()]);
            }

            return Response()->json([
                'message' => 'Game updated'
            ],200);


        }catch (\Exception $exception){
            return Response()->json([
                'message' => $exception->getMessage()
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $removed = Game::destroy($id);
            if($removed){
                throw new \Exception("Unable to delete game");
            }

            return Response()->json([
                "message" => "Game deleted"
            ],204);

        }catch (\Exception $exception){
            return Response()->json([
                'message' => $exception->getMessage()
            ],400);
        }
    }
}
