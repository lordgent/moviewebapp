<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('username', session('user'))->first();
        if (!$user)
            return redirect()->route('login');

        $favoriteItems = Favorite::where('user_id', $user->id)->get();

        $favorites = [];
        $apiKey = env('OMDB_API_KEY', 'your_api_key_here');

        foreach ($favoriteItems as $item) {
            $movie = Cache::remember('movie_' . $item->imdb_id, 3600, function () use ($item, $apiKey) {
                try {
                    $url = "http://www.omdbapi.com/?apikey={$apiKey}&i={$item->imdb_id}";

                    $opts = ["http" => ["header" => "User-Agent: PHP\r\n"]];
                    $context = stream_context_create($opts);

                    $json = file_get_contents($url, false, $context);
                    return json_decode($json, true);
                } catch (\Exception $e) {
                    return null;
                }
            });

            if ($movie && isset($movie['Title'])) {
                $favorites[] = $movie;
            }
        }

        return view('favorite.list', compact('favorites'));
    }

    public function add(Request $request)
    {
        $user = User::where('username', session('user'))->first();
        if (!$user)
            return response()->json(['success' => false], 401);

        Favorite::firstOrCreate([
            'user_id' => $user->id,
            'imdb_id' => $request->imdbID,
        ]);

        return response()->json([
            'success' => true,
            'message' => trans('messages.saved_to_fav') ?? 'Saved to favorites!'
        ]);
    }

    public function remove(Request $request)
    {
        $user = User::where('username', session('user'))->first();
        if (!$user)
            return response()->json(['success' => false], 401);

        Favorite::where('user_id', $user->id)
            ->where('imdb_id', $request->imdbID)
            ->delete();

        return response()->json(['success' => true]);
    }
}