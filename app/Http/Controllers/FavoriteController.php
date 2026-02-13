<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $favorites = $request->session()->get('favorites', []);
        return view('movies.favorite', compact('favorites'));
    }

    public function add(Request $request)
    {
        $movie = $request->input('movie');
        $favorites = $request->session()->get('favorites', []);
        $favorites[$movie['imdbID']] = $movie;
        $request->session()->put('favorites', $favorites);

        return response()->json(['success' => true]);
    }

    public function remove(Request $request)
    {
        $imdbID = $request->input('imdbID');
        $favorites = $request->session()->get('favorites', []);
        unset($favorites[$imdbID]);
        $request->session()->put('favorites', $favorites);

        return response()->json(['success' => true]);
    }
}
