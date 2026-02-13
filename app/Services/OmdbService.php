<?php 

namespace App\Services;

use GuzzleHttp\Client;

class OmdbService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OMDB_API_KEY');
    }




    public function detail($imdbID)
    {
        $response = $this->client->get('http://www.omdbapi.com/', [
            'query' => [
                'apikey' => $this->apiKey,
                'i' => $imdbID
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function searchLatest($page = 1)
{
    $year = date('Y'); // Tahun sekarang
    return $this->search('movie', $page, $year); // 'movie' = keyword default
}

public function search($query, $page = 1, $year = null)
{
    $params = [
        'apikey' => $this->apiKey,
        's' => $query,
        'page' => $page
    ];

    if ($year) {
        $params['y'] = $year;
    }

    $response = $this->client->get('http://www.omdbapi.com/', [
        'query' => $params
    ]);

    return json_decode($response->getBody(), true);
}


    public function getByTitle($title)
    {
        $response = $this->client->get('http://www.omdbapi.com/', [
            'query' => [
                'apikey' => $this->apiKey,
                't' => $title,  
                'r' => 'json'
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
