<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Nivo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NivoController extends Controller
{
    public function index()
    {

        return response()->json(
            Nivo::query()
                ->orderBy('tezina')
                ->orderBy('id')
                ->get()
        );
    }

    public function show($id)
    {

        $nivo = Nivo::find($id);

        if (!$nivo) {
            return response()->json(['message' => 'Nivo nije pronađen'], 404);
        }

        return response()->json($nivo);
    }

    public function phases($id)
    {

        $nivo = Nivo::find($id);

        if (!$nivo) {
            return response()->json(['message' => 'Nivo nije pronađen'], 404);
        }

        $cfg = $nivo->level_config ?? [];
        $phases = $cfg['phases'] ?? [];

        return response()->json($phases);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'naziv' => 'required|string|max:255',
                'opis' => 'nullable|string',
                'tezina' => 'required|integer|min:1|max:5',
                'expected' => 'nullable|array',
                'level_config' => 'nullable|array',
                'hint' => 'nullable|string',
                'is_active' => 'boolean',
            ]);

            $nivo = Nivo::create($validated);
            return response()->json($nivo, 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        $nivo = Nivo::find($id);

        if (!$nivo) {
            return response()->json(['message' => 'Nivo nije pronađen'], 404);
        }

        $validated = $request->validate([
            'naziv' => 'sometimes|required|string|max:255',
            'opis' => 'sometimes|nullable|string',
            'tezina' => 'sometimes|required|integer|min:1|max:5',
            'expected' => 'sometimes|nullable|array',
            'level_config' => 'sometimes|nullable|array',
            'hint' => 'sometimes|nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $nivo->update($validated);
        return response()->json($nivo);
    }

    public function destroy($id)
    {
        $nivo = Nivo::find($id);

        if (!$nivo) {
            return response()->json(['message' => 'Nivo nije pronađen'], 404);
        }

        $nivo->delete();
        return response()->json(['message' => 'Nivo obrisan']);
    }
}
