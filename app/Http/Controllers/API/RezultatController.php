<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Rezultat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RezultatController extends Controller
{
    public function index()
    {
        return response()->json(
            Rezultat::with(['korisnik', 'nivo'])->get()
        );
    }

    public function show($id)
    {
        $r = Rezultat::with(['korisnik', 'nivo'])->find($id);
        if (!$r) return response()->json(['message' => 'Rezultat nije pronađen'], 404);
        return response()->json($r);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'korisnik_id' => 'required|exists:korisniks,id',
            'nivo_id' => 'required|exists:nivos,id',
            'poeni' => 'required|integer|min:0',
            'vreme_sekunde' => 'nullable|integer|min:0',
        ]);

        $rezultat = Rezultat::create($validated);
        return response()->json($rezultat, 201);
    }

    public function update(Request $request, $id)
    {
        $rezultat = Rezultat::find($id);
        if (!$rezultat) return response()->json(['message' => 'Rezultat nije pronađen'], 404);

        $validated = $request->validate([
            'poeni' => 'sometimes|required|integer|min:0',
            'vreme_sekunde' => 'sometimes|nullable|integer|min:0',
        ]);

        $rezultat->update($validated);
        return response()->json($rezultat);
    }

    public function destroy($id)
    {
        $rezultat = Rezultat::find($id);
        if (!$rezultat) return response()->json(['message' => 'Rezultat nije pronađen'], 404);

        $rezultat->delete();
        return response()->json(['message' => 'Rezultat obrisan']);
    }


   public function leaderboard()
{
    $rows = DB::table('rezultats as r')
        ->join('korisniks as k', 'k.id', '=', 'r.korisnik_id')
        ->select(
            'k.id as korisnik_id',
            'k.username',
            DB::raw('SUM(r.poeni) as total_poeni')
        )
        ->groupBy('k.id', 'k.username')
        ->orderByDesc('total_poeni')
        ->limit(20)
        ->get();

    return response()->json($rows);
}


    public function completePhase(Request $request, $nivoId, $phaseId)
{
    $validated = $request->validate([
        'korisnik_id' => 'required|exists:korisniks,id',
    ]);

    $points = 100;

    DB::table('rezultats')->updateOrInsert(
        [
            'korisnik_id' => (int)$validated['korisnik_id'],
            'nivo_id'     => (int)$nivoId,
            'phase_id'    => (string)$phaseId,
        ],
        [
            'poeni'       => $points,
            'updated_at'  => now(),
            'created_at'  => now(),
        ]
    );

    $total = (int) DB::table('rezultats')
        ->where('korisnik_id', (int)$validated['korisnik_id'])
        ->sum('poeni');

    return response()->json([
        'ok' => true,
        'added_points' => $points,
        'total_points' => $total,
        'nivo_id' => (int)$nivoId,
        'phase_id' => (string)$phaseId,
    ]);
}

}
