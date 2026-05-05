<?php

namespace App\Http\Controllers;
use App\Models\Game;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\json;

class AdminController extends Controller
{
    //
    public function users(Request $request)
    {
        $query = User::with('school')
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('name',     'like', "%{$request->search}%")
                      ->orWhere('email',    'like', "%{$request->search}%")
                      ->orWhere('username', 'like', "%{$request->search}%");
                });
            })
            ->when($request->role, fn($q) => $q->where('role', $request->role))
            ->orderBy('created_at', 'desc');
    
        return response()->json($query->paginate($request->per_page ?? 15));
    }

    public function updateUser(Request $request, $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        if ($user->username === auth()->user()->username && $request->role !== 'admin') {
            return response()->json(['message' => 'Você não pode remover seu próprio cargo de admin'],422);
        }

        $request->validate([
            'role' => 'sometimes|in:user,student,professor,admin',
            'banned' => 'sometimes|boolean'
        ]);

        $user->update($request->only(['role', 'banned']));
        return response()->json($user->load('school'));
    }

    public function games(Request $request)
    {
        $query = Game::with(['user', 'school'])
            ->when($request->serch, fn($q) =>
                $q->where('name', 'like', '%{$request->search}%')
            )
            ->OrderBy('created_at', 'desc');

        return response()->json($query->paginate($request->per_page ?? 15));
    }

    public function updateGame(Request $request, $slug)
    {
        $game = Game::where('slug', $slug)->firstOrFail();

        $request->validate([
            'featured' => 'required|boolean',
        ]);

        $game->update(['featured' => $request->featured]);

        return response()->json($game->load(['user', 'school']));
    }

    public function deleteGame($slug)
    {
        $game = Game::where('slug', $slug)->firstOrFail();

        if ($game->image) {
            $path = parse_url($game->image, PHP_URL_PATH);
            $filename = basename($path);
            Storage::disk('supabase')->delete("gameimages/{$filename}");
        }

        $game->delete();

        return response()->json(null, 204);
    }

    public function schools(Request $request)
    {
        $query = School::withCount('user')
            ->where('id', '!=', 1)
            ->when($request->search, fn($q) =>
                $q->where('name', 'like', "%{$request->search}%")
            )
            ->OrderBy('name');

        return response()->json($query->get());
    }

    public function createSchool(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:schools,name',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:2'
        ]);

        $school = School::create($request->only(['name', 'city', 'state']));

        return response()->json($school, 201);
    }

    public function updateSchool(Request $request, $id)
    {
        if ($id == 1){
            return response()->json(['message' => 'Escola padrão não pode ser editada'],422);
        }

        $school = School::findOrFail($id);

        $request->validate([
            'name' => "sometimes|string|max:255|unique:schools,name,{$id}",
            'city' => 'sometimes|nullable|string|max:100',
            'state' => 'sometimes|nullable|string|max:2',
        ]);

        $school->update($request->only(['name', 'city', 'state']));

        return response()->json($school);
    }


    public function deleteSchool($id)
    {
        if ($id == 1) {
            return response()->json(['message' => 'Escola padrão não pode ser removida'],422);
        }

        $school = School::withCount('user')->findOrFail($id);

        if ($school->user_count > 0) {
            return response()->json([
            'message' => "Essa escola possui {$school->user_count} usuário(s) vinculado(s). Desvincule-os antes de remover."
            ],422);
        }
        $school->delete();

        return response()->json(null, 204);
    }
}
