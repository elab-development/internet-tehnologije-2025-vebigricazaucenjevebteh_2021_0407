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
            if (in_array('gost', $tipovi, true)) {
                return $next($request);
            }

            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }


        $tip = $user->tip_korisnika ?? null;

        if (!$tip) {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        if (!in_array($tip, $tipovi, true)) {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        return $next($request);
    }
}
