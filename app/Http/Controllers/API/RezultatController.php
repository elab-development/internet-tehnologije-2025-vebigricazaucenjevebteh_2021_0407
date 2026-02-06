<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rezultat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RezultatController extends Controller
{

    public function completePhase(Request $request, $nivoId, $phaseId)
    {
        $korisnikId = Auth::id();


        $postoji = Rezultat::where('korisnik_id', $korisnikId)
            ->where('nivo_id', $nivoId)
            ->where('phase_id', $phaseId)
            ->exists();

        if ($postoji) {
            return response()->json([
                'message' => 'Poeni za ovu fazu su već dodeljeni'
            ], 200);
        }

        $rezultat = Rezultat::create([
            'korisnik_id' => $korisnikId,
            'nivo_id'     => $nivoId,
            'phase_id'    => $phaseId,
            'poeni'       => 100,
        ]);

        return response()->json([
            'message' => 'Poeni uspešno upisani',
            'rezultat' => $rezultat
        ], 201);
    }


    public function store(Request $request)
    {
        $request->validate([
            'nivo_id' => 'required|integer',
            'phase_id' => 'required|integer',
        ]);

        $korisnikId = Auth::id();

        $postoji = Rezultat::where('korisnik_id', $korisnikId)
            ->where('phase_id', $request->phase_id)
            ->exists();

        if ($postoji) {
            return response()->json([
                'message' => 'Poeni za ovu fazu su već dodeljeni'
            ], 200);
        }

        $rezultat = Rezultat::create([
            'korisnik_id' => $korisnikId,
            'nivo_id' => $request->nivo_id,
            'phase_id' => $request->phase_id,
            'poeni' => 100,
        ]);

        return response()->json($rezultat, 201);
    }

     public function leaderboard()
    {
        $leaderboard = DB::table('rezultats')
            ->join('korisniks', 'rezultats.korisnik_id', '=', 'korisniks.id')
            ->select(
                'korisniks.email',
                DB::raw('SUM(rezultats.poeni) as ukupno_poena')
            )
            ->groupBy('korisniks.email')
            ->orderByDesc('ukupno_poena')
            ->get();

        return response()->json($leaderboard);
    }
}



