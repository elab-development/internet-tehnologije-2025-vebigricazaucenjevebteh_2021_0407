<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NivoController;
use App\Http\Controllers\API\HTMLBlockController;
use App\Http\Controllers\API\NivoHTMLBlockController;
use App\Http\Controllers\API\PokusajController;
use App\Http\Controllers\API\RezultatController;
use App\Http\Controllers\ExternalApiController;



Route::get('/test', fn () => response()->json(['ok' => true]));


Route::get('/nivos', [NivoController::class, 'index']);
Route::get('/nivos/{id}', [NivoController::class, 'show']);
Route::get('/nivos/{id}/phases', [NivoController::class, 'phases']);


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/auth/logout', [AuthController::class, 'logout']);


    Route::post(
        '/nivos/{nivoId}/phases/{phaseId}/complete',
        [RezultatController::class, 'completePhase']
    );


    Route::get('/leaderboard', [RezultatController::class, 'leaderboard']);
});


Route::middleware(['auth:sanctum', 'tip:editor,administrator'])->group(function () {


    Route::post('/nivos', [NivoController::class, 'store']);
    Route::put('/nivos/{id}', [NivoController::class, 'update']);


    Route::post('/html-blocks', [HTMLBlockController::class, 'store']);
    Route::put('/html-blocks/{id}', [HTMLBlockController::class, 'update']);


    Route::post('/nivo-html-blocks', [NivoHTMLBlockController::class, 'store']);
    Route::put('/nivo-html-blocks/{id}', [NivoHTMLBlockController::class, 'update']);
});


Route::middleware(['auth:sanctum', 'tip:administrator'])->group(function () {


    Route::delete('/nivos/{id}', [NivoController::class, 'destroy']);


    Route::delete('/html-blocks/{id}', [HTMLBlockController::class, 'destroy']);


    Route::get('/nivo-html-blocks', [NivoHTMLBlockController::class, 'index']);
    Route::get('/nivo-html-blocks/{id}', [NivoHTMLBlockController::class, 'show']);
    Route::delete('/nivo-html-blocks/{id}', [NivoHTMLBlockController::class, 'destroy']);


    Route::get('/pokusaji', [PokusajController::class, 'index']);
    Route::get('/pokusaji/{id}', [PokusajController::class, 'show']);
    Route::post('/pokusaji', [PokusajController::class, 'store']);
    Route::put('/pokusaji/{id}', [PokusajController::class, 'update']);
    Route::delete('/pokusaji/{id}', [PokusajController::class, 'destroy']);


    Route::get('/rezultati', [RezultatController::class, 'index']);
    Route::get('/rezultati/{id}', [RezultatController::class, 'show']);
    Route::post('/rezultati', [RezultatController::class, 'store']);
    Route::put('/rezultati/{id}', [RezultatController::class, 'update']);
    Route::delete('/rezultati/{id}', [RezultatController::class, 'destroy']);
});


Route::get('/html-blocks', [HTMLBlockController::class, 'index']);
Route::get('/html-blocks/{id}', [HTMLBlockController::class, 'show']);

Route::get('/external/trivia', [ExternalApiController::class, 'getTrivia']);
Route::get('/external/pexels', [ExternalApiController::class, 'getPexels']);
Route::get('/daily-trivia', [ExternalApiController::class, 'dailyTrivia']);


