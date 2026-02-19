<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;



class ExternalApiController extends Controller
{

    public function getTrivia()
    {
        $response = Http::get('https://opentdb.com/api.php', [
            'amount' => 5,
            'category' => 18,
            'type' => 'multiple'
        ]);

        return response()->json($response->json());
    }


   public function getPexels(Request $request)
{
    $nivo = $request->query('nivo', 1);


    if ($nivo != 1) {
        return response()->json([
            'message' => 'Nema slike za ovaj nivo'
        ]);
    }

    $apiKey = getenv('PEXELS_API_KEY');

    /** @var \Illuminate\Http\Client\Response $response */
    $response = Http::withHeaders([
        'Authorization' => $apiKey
    ])->get('https://api.pexels.com/v1/search', [
        'query' => 'html',
        'per_page' => 5
    ]);

    return response()->json($response->json());
}

public function dailyTrivia()
{
    $today = now()->format('Y-m-d');


    $dayNumber = now()->day;
    $category = ($dayNumber % 4) + 9;


    $response = Http::get('https://opentdb.com/api.php', [
        'amount' => 1,
        'category' => $category,
        'type' => 'multiple'
    ]);

    return response()->json([
        'datum' => $today,
        'question' => $response->json()['results'][0] ?? null
    ]);
}


}
