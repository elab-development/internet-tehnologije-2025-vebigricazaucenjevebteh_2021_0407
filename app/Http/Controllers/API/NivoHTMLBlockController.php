<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\NivoHTMLBlock;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;


class NivoHTMLBlockController extends Controller
{
    public function index()
    {
        return response()->json(
            NivoHTMLBlock::with(['nivo', 'htmlBlock'])->get()
        );
    }

    public function show($id)
    {
        $item = NivoHTMLBlock::with(['nivo', 'htmlBlock'])->find($id);
        if (!$item) return response()->json(['message' => 'Veza nije pronađena'], 404);
        return response()->json($item);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nivo_id' => 'required|exists:nivos,id',
            'html_block_id' => 'required|exists:html_blocks,id',
            'pozicija' => 'nullable|integer|min:1',
            'obavezno' => 'nullable|boolean',
        ]);

        $created = NivoHTMLBlock::create($validated);
        return response()->json($created, 201);
    }

    public function update(Request $request, $id)
    {
        $item = NivoHTMLBlock::find($id);
        if (!$item) return response()->json(['message' => 'Veza nije pronađena'], 404);

        $validated = $request->validate([
            'pozicija' => 'sometimes|nullable|integer|min:1',
            'obavezno' => 'sometimes|nullable|boolean',
        ]);

        $item->update($validated);
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = NivoHTMLBlock::find($id);
        if (!$item) return response()->json(['message' => 'Veza nije pronađena'], 404);

        $item->delete();
        return response()->json(['message' => 'Veza obrisana']);
    }
}
