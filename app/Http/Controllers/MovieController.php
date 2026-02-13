<?php

namespace App\Http\Controllers;

use App\Services\OmdbService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $omdb;

    public function __construct(OmdbService $omdb)
    {
        $this->omdb = $omdb;
    }

 public function index(Request $request)
{
    $query = $request->input('q', '');
    $page = $request->input('page', 1);

    if (empty($query)) {
        $movies = $this->omdb->searchLatest($page);
    } else {
        $movies = $this->omdb->search($query, $page);
    }

    return view('movies.list', compact('movies', 'query', 'page'));
}


    public function detail($imdbID)
    {
        $movie = $this->omdb->detail($imdbID);
        return view('movies.detail', compact('movie'));
    }
}
