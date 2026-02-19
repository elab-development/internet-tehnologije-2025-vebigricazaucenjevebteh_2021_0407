<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HTMLBlock;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;


class HTMLBlockController extends Controller
{
    public function index()
    {
        return response()->json(HTMLBlock::all());
    }

    public function show($id)
    {
        $block = HTMLBlock::find($id);
        if (!$block) return response()->json(['message' => 'HTML blok nije pronađen'], 404);
        return response()->json($block);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'kod' => 'required|string',
            'opis' => 'nullable|string',
            'kategorija' => 'nullable|string|max:255',
        ]);

        $block = HTMLBlock::create($validated);
        return response()->json($block, 201);
    }

    public function update(Request $request, $id)
    {
        $block = HTMLBlock::find($id);
        if (!$block) return response()->json(['message' => 'HTML blok nije pronađen'], 404);

        $validated = $request->validate([
            'naziv' => 'sometimes|required|string|max:255',
            'kod' => 'sometimes|required|string',
            'opis' => 'sometimes|nullable|string',
            'kategorija' => 'sometimes|nullable|string|max:255',
        ]);

        $block->update($validated);
        return response()->json($block);
    }

    public function destroy($id)
    {
        $block = HTMLBlock::find($id);
        if (!$block) return response()->json(['message' => 'HTML blok nije pronađen'], 404);

        $block->delete();
        return response()->json(['message' => 'HTML blok obrisan']);
    }
}
