<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            $username = $request->input('username');

            $query = Game::query();

            if ($username) {
                $query->whereHas('user', function ($q) use ($username) {
                    $q->where('username', $username);
                });
            }

            switch ($section) {
                case 'created':
                    $query->orderBy('games.created_at', 'desc');
                    break;
                case 'clicks':
                    $query->orderBy('games.clicks', 'desc');
                    break;
                case 'updated':
                    $query->orderBy('games.updated_at', 'desc');
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

        $user = $request->user();


        try{
            if($request->hasfile('image')){

                $imagePath = $request->file('image')->store('gameimages', 'supabase');
            }

            
            
            
            $game = Game::create([
                ...$request->validated(),
                'slug' => Str::slug($request->name),
                'image' => $imagePath,
                'clicks' => 10,
                'user_id' => $user->id,
                'school_id' => $user->school_id,
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
    public function show(string $slug)
    {
        $game = Game::where('slug', $slug)->firstOrFail();
        $user = User::where('id', $game->user_id)->firstOrFail();
        $school = School::where('id', $game->school_id)->firstOrFail();
        

        
        return response()->json([
            ...$game->toArray(),
            'creator_username' => $user->username,
            'creator_name' => $user->name,
            'school_name' => $school->name,
        ],200);
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

            $slug = Str::slug($request->name);

            

            if ($imagePath) {

                $game = Game::findOrFail($id);
                $game->update([
                    ...$request->validated(),
                    'slug' => $slug,
                    'image' => $imagePath,
                ]);
               
            }
            else {
                $game = Game::findOrFail($id);
                $game->update([
                    ...$request->validated(),
                    'slug' => $slug,
                ]);
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
