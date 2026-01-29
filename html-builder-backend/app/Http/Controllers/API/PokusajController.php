<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pokusaj;
use Illuminate\Http\Request;

class PokusajController extends Controller
{
    public function index()
    {
        return response()->json(
            Pokusaj::with(['korisnik', 'nivo'])->get()
        );
    }

    public function show($id)
    {
        $p = Pokusaj::with(['korisnik', 'nivo'])->find($id);
        if (!$p) return response()->json(['message' => 'Pokušaj nije pronađen'], 404);
        return response()->json($p);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'korisnik_id' => 'required|exists:korisniks,id',
            'nivo_id' => 'required|exists:nivos,id',
            'uspesan' => 'nullable|boolean',
            'vreme_sekunde' => 'nullable|integer|min:0',
            'broj_gresaka' => 'nullable|integer|min:0',
        ]);

        $pokusaj = Pokusaj::create($validated);
        return response()->json($pokusaj, 201);
    }

    public function update(Request $request, $id)
    {
        $pokusaj = Pokusaj::find($id);
        if (!$pokusaj) return response()->json(['message' => 'Pokušaj nije pronađen'], 404);

        $validated = $request->validate([
            'uspesan' => 'sometimes|nullable|boolean',
            'vreme_sekunde' => 'sometimes|nullable|integer|min:0',
            'broj_gresaka' => 'sometimes|nullable|integer|min:0',
        ]);

        $pokusaj->update($validated);
        return response()->json($pokusaj);
    }

    public function destroy($id)
    {
        $pokusaj = Pokusaj::find($id);
        if (!$pokusaj) return response()->json(['message' => 'Pokušaj nije pronađen'], 404);

        $pokusaj->delete();
        return response()->json(['message' => 'Pokušaj obrisan']);
    }
}
