<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class DailyController extends Controller
{
    public function index()
    {
        $response = Http::get('https://opentdb.com/api.php?amount=1&category=18&type=multiple');

        if (!$response->successful()) {
            return response()->json([
                'message' => 'Greška pri dohvatanju pitanja'
            ], 500);
        }

        $data = $response->json();

        if (empty($data['results'])) {
            return response()->json([
                'message' => 'Nema pitanja'
            ], 404);
        }

        $question = $data['results'][0];

        $answers = collect($question['incorrect_answers'])
            ->push($question['correct_answer'])
            ->shuffle()
            ->map(fn($a) => html_entity_decode($a))
            ->values();

        return response()->json([
            'date' => Carbon::today()->toDateString(),
            'question' => html_entity_decode($question['question']),
            'correct_answer' => html_entity_decode($question['correct_answer']),
            'answers' => $answers
        ]);
    }
}
