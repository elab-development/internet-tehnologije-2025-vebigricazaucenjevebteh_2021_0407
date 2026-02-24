<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rezultat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;
class RezultatController extends Controller
{
#[OA\Post(
    path: "/api/nivos/{nivoId}/phases/{phaseId}/complete",
    operationId: "completePhase",
    tags: ["Rezultati"],
    summary: "Završetak faze i dodela poena",
    security: [["sanctum" => []]],
    parameters: [
        new OA\Parameter(
            name: "nivoId",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        ),
        new OA\Parameter(
            name: "phaseId",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],
    responses: [
        new OA\Response(response: 201, description: "Poeni upisani")
    ]
)]
    public function completePhase(Request $request, $nivoId, $phaseId)
{
    $korisnikId = Auth::id();

    if (!$korisnikId) {
        return response()->json([
            'message' => 'Korisnik nije autentifikovan'
        ], 401);
    }

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
        'created_at'  => now(),
        'updated_at'  => now(),
    ]);

    return response()->json([
        'message'  => 'Poeni uspešno upisani',
        'rezultat' => $rezultat
    ], 201);
}


   public function store(Request $request)
{
    $request->validate([
        'nivo_id'  => 'required|integer',
        'phase_id' => 'required|integer',
    ]);

    $korisnikId = Auth::id();

    if (!$korisnikId) {
        return response()->json([
            'message' => 'Korisnik nije autentifikovan'
        ], 401);
    }

    $postoji = Rezultat::where('korisnik_id', $korisnikId)
        ->where('nivo_id', $request->nivo_id)
        ->where('phase_id', $request->phase_id)
        ->exists();

    if ($postoji) {
        return response()->json([
            'message' => 'Poeni za ovu fazu su već dodeljeni'
        ], 200);
    }

    $rezultat = Rezultat::create([
        'korisnik_id' => $korisnikId,
        'nivo_id'     => $request->nivo_id,
        'phase_id'    => $request->phase_id,
        'poeni'       => 100,
        'created_at'  => now(),
        'updated_at'  => now(),
    ]);

    return response()->json([
        'message'  => 'Poeni uspešno upisani',
        'rezultat' => $rezultat
    ], 201);
}

     /*public function leaderboard()
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
        */
    #[OA\Get(
    path: "/api/leaderboard",
    operationId: "getLeaderboard",
    tags: ["Leaderboard"],
    summary: "Prikaz leaderboard liste",
    description: "Vraća listu korisnika sa ukupnim brojem poena",
    responses: [
        new OA\Response(
            response: 200,
            description: "Uspešan odgovor"
        )
        ]
    )]
    public function leaderboard()
{
    $leaderboard = DB::table('rezultats')
        ->join('korisniks', 'rezultats.korisnik_id', '=', 'korisniks.id')
        ->select(
            'korisniks.id',
            'korisniks.email',
            DB::raw('SUM(rezultats.poeni) as ukupno_poena')
        )
        ->groupBy('korisniks.id', 'korisniks.email')
        ->orderByDesc('ukupno_poena')
        ->get();

    return response()->json($leaderboard);
}

public function statistika()
{
    $podaci = DB::table('rezultats')
        ->join('korisniks', 'rezultats.korisnik_id', '=', 'korisniks.id')
        ->select(
            'korisniks.ime',
            DB::raw('SUM(rezultats.poeni) as ukupno_bodova')
        )
        ->groupBy('korisniks.ime')
        ->get();

    return response()->json($podaci);
}
}



