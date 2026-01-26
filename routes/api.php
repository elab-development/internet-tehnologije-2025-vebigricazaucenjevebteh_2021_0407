<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NivoController;
use App\Http\Controllers\API\HTMLBlockController;
use App\Http\Controllers\API\NivoHTMLBlockController;
use App\Http\Controllers\API\PokusajController;
use App\Http\Controllers\API\RezultatController;

// PUBLIC (Gost može)
Route::get('/nivoi', [NivoController::class, 'index']);
Route::get('/nivoi/{id}', [NivoController::class, 'show']);
Route::get('/html-blocks', [HTMLBlockController::class, 'index']);
Route::get('/html-blocks/{id}', [HTMLBlockController::class, 'show']);
Route::get('/leaderboard', [RezultatController::class, 'leaderboard']);

// PROTECTED (registrovani/editor/admin)
Route::middleware('auth:sanctum')->group(function () {
    // Nivo CRUD
    Route::post('/nivoi', [NivoController::class, 'store']);
    Route::put('/nivoi/{id}', [NivoController::class, 'update']);
    Route::delete('/nivoi/{id}', [NivoController::class, 'destroy']);

    // HTMLBlock CRUD
    Route::post('/html-blocks', [HTMLBlockController::class, 'store']);
    Route::put('/html-blocks/{id}', [HTMLBlockController::class, 'update']);
    Route::delete('/html-blocks/{id}', [HTMLBlockController::class, 'destroy']);

    // NivoHTMLBlock CRUD (veze)
    Route::get('/nivo-html-blocks', [NivoHTMLBlockController::class, 'index']);
    Route::get('/nivo-html-blocks/{id}', [NivoHTMLBlockController::class, 'show']);
    Route::post('/nivo-html-blocks', [NivoHTMLBlockController::class, 'store']);
    Route::put('/nivo-html-blocks/{id}', [NivoHTMLBlockController::class, 'update']);
    Route::delete('/nivo-html-blocks/{id}', [NivoHTMLBlockController::class, 'destroy']);

    // Pokusaj
    Route::get('/pokusaji', [PokusajController::class, 'index']);
    Route::get('/pokusaji/{id}', [PokusajController::class, 'show']);
    Route::post('/pokusaji', [PokusajController::class, 'store']);
    Route::put('/pokusaji/{id}', [PokusajController::class, 'update']);
    Route::delete('/pokusaji/{id}', [PokusajController::class, 'destroy']);

    // Rezultat
    Route::get('/rezultati', [RezultatController::class, 'index']);
    Route::get('/rezultati/{id}', [RezultatController::class, 'show']);
    Route::post('/rezultati', [RezultatController::class, 'store']);
    Route::put('/rezultati/{id}', [RezultatController::class, 'update']);
    Route::delete('/rezultati/{id}', [RezultatController::class, 'destroy']);
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

});
