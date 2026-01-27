<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TipKorisnikaMiddleware
{
    public function handle(Request $request, Closure $next, ...$tipovi)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $tip = $user->tip_korisnika ?? null;

        if (!$tip || !in_array($tip, $tipovi, true)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
