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
    public function index(Request $request)
    {
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
