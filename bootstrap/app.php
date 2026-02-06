<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {


    $middleware->append(
        \Illuminate\Http\Middleware\HandleCors::class
    );


    $middleware->group('api', [
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        'throttle:api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ]);


    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
        'tip'  => \App\Http\Middleware\TipKorisnikaMiddleware::class,
        'tip_korisnika' => \App\Http\Middleware\TipKorisnikaMiddleware::class,
    ]);
})

    ->withExceptions(function (Exceptions $exceptions): void {

    })->create();
