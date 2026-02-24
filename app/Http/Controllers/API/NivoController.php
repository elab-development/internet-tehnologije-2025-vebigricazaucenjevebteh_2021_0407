<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Nivo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;

class NivoController extends Controller
{

   #[OA\Get(
    path: "/api/nivos",
    operationId: "getAllNivos",
    tags: ["Nivoi"],
    summary: "Prikaz svih nivoa",
    responses: [
        new OA\Response(
            response: 200,
            description: "Lista svih nivoa"
        )
    ]
)]
    public function index()
    {

        return response()->json(
            Nivo::query()
                ->orderBy('tezina')
                ->orderBy('id')
                ->get()
        );
    }
    #[OA\Get(
    path: "/api/nivos/{id}",
    operationId: "getSingleNivo",
    tags: ["Nivoi"],
    summary: "Prikaz jednog nivoa",
    parameters: [
        new OA\Parameter(
            name: "id",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: "Detalji nivoa"
        ),
        new OA\Response(
            response: 404,
            description: "Nivo nije pronađen"
        )
    ]
)]
    public function show($id)
    {

        $nivo = Nivo::find($id);

        if (!$nivo) {
            return response()->json(['message' => 'Nivo nije pronađen'], 404);
        }

        return response()->json($nivo);
    }
    #[OA\Get(
    path: "/api/nivos/{id}/phases",
    operationId: "getNivoPhases",
    tags: ["Nivoi"],
    summary: "Prikaz faza određenog nivoa",
    parameters: [
        new OA\Parameter(
            name: "id",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: "Lista faza"
        ),
        new OA\Response(
            response: 404,
            description: "Nivo nije pronađen"
        )
    ]
)]
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
    #[OA\Post(
    path: "/api/nivos",
    operationId: "createNivo",
    tags: ["Nivoi"],
    summary: "Kreiranje novog nivoa",
    security: [["sanctum" => []]],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["naziv","tezina"],
            properties: [
                new OA\Property(property: "naziv", type: "string", example: "HTML Osnove"),
                new OA\Property(property: "opis", type: "string", example: "Prvi nivo"),
                new OA\Property(property: "tezina", type: "integer", example: 1),
                new OA\Property(property: "hint", type: "string", example: "Koristi <p> tag"),
                new OA\Property(property: "is_active", type: "boolean", example: true)
            ]
        )
    ),
    responses: [
        new OA\Response(response: 201, description: "Nivo kreiran"),
        new OA\Response(response: 422, description: "Validation error")
    ]
)]
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
    #[OA\Put(
    path: "/api/nivos/{id}",
    operationId: "updateNivo",
    tags: ["Nivoi"],
    summary: "Izmena nivoa",
    security: [["sanctum" => []]],
    parameters: [
        new OA\Parameter(
            name: "id",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],
    responses: [
        new OA\Response(response: 200, description: "Nivo ažuriran"),
        new OA\Response(response: 404, description: "Nivo nije pronađen")
    ]
)]
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
    #[OA\Delete(
    path: "/api/nivos/{id}",
    operationId: "deleteNivo",
    tags: ["Nivoi"],
    summary: "Brisanje nivoa",
    security: [["sanctum" => []]],
    parameters: [
        new OA\Parameter(
            name: "id",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],
    responses: [
        new OA\Response(response: 200, description: "Nivo obrisan"),
        new OA\Response(response: 404, description: "Nivo nije pronađen")
    ]
)]
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
