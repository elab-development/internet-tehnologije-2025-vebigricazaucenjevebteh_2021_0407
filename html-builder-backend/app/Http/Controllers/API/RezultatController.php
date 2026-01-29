<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Rezultat;
use Illuminate\Http\Request;

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

    // BONUS (korisno): leaderboard
    public function leaderboard()
    {
        $top = Rezultat::with(['korisnik', 'nivo'])
            ->orderByDesc('poeni')
            ->limit(20)
            ->get();

        return response()->json($top);
    }
}
