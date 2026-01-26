<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Nivo;
use Illuminate\Http\Request;

class NivoController extends Controller
{
    public function index()
    {
        return response()->json(Nivo::all());
    }

    public function show($id)
    {
        $nivo = Nivo::find($id);
        if (!$nivo) return response()->json(['message' => 'Nivo nije pronađen'], 404);
        return response()->json($nivo);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'opis' => 'nullable|string',
            'tezina' => 'required|integer|min:1|max:5',
        ]);

        $nivo = Nivo::create($validated);
        return response()->json($nivo, 201);
    }

    public function update(Request $request, $id)
    {
        $nivo = Nivo::find($id);
        if (!$nivo) return response()->json(['message' => 'Nivo nije pronađen'], 404);

        $validated = $request->validate([
            'naziv' => 'sometimes|required|string|max:255',
            'opis' => 'sometimes|nullable|string',
            'tezina' => 'sometimes|required|integer|min:1|max:5',
        ]);

        $nivo->update($validated);
        return response()->json($nivo);
    }

    public function destroy($id)
    {
        $nivo = Nivo::find($id);
        if (!$nivo) return response()->json(['message' => 'Nivo nije pronađen'], 404);

        $nivo->delete();
        return response()->json(['message' => 'Nivo obrisan']);
    }
}
