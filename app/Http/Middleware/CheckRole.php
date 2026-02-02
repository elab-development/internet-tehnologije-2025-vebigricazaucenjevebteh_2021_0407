<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        // gost
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // nema dozvoljenu ulogu
        if (!in_array($user->tip_korisnika, $roles)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
