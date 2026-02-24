<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Korisnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;


class AuthController extends Controller
{
#[OA\Post(
    path: "/api/auth/register",
    operationId: "registerUser",
    tags: ["Auth"],
    summary: "Registracija korisnika",
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["email","password"],
            properties: [
                new OA\Property(property: "email", type: "string", example: "test@gmail.com"),
                new OA\Property(property: "password", type: "string", example: "password123")
            ]
        )
    ),
    responses: [
        new OA\Response(response: 201, description: "Uspešna registracija")
    ]
)]
    public function register(Request $request)
    {
        $validated = $request->validate([
            'ime' => 'required|string|max:255',
            'email' => 'required|email|unique:korisniks,email',
            'password' => 'required|string|min:6|confirmed',

        ]);

        $korisnik = Korisnik::create([
            'ime' => $validated['ime'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'tip_korisnika'=>'registrovani',
        ]);

        $token = $korisnik->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Registracija uspešna',
            'korisnik' => [
                'id' => $korisnik->id,
                'ime' => $korisnik->ime,
                'email' => $korisnik->email,
                'tip_korisnika' => $korisnik->tip_korisnika,
            ],
            'token' => $token,
        ], 201);
    }
#[OA\Post(
    path: "/api/auth/login",
    operationId: "loginUser",
    tags: ["Auth"],
    summary: "Prijava korisnika",
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["email","password"],
            properties: [
                new OA\Property(property: "email", type: "string", example: "test@gmail.com"),
                new OA\Property(property: "password", type: "string", example: "password123")
            ]
        )
    ),
    responses: [
        new OA\Response(response: 200, description: "Uspešna prijava")
    ]
)]
   public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = Korisnik::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'Korisnik ne postoji'], 404);
    }

    if (!Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Lozinka nije dobra'], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ]);
}
#[OA\Post(
    path: "/api/auth/logout",
    operationId: "logoutUser",
    tags: ["Auth"],
    summary: "Odjava korisnika",
    security: [["sanctum" => []]],
    responses: [
        new OA\Response(response: 200, description: "Uspešna odjava")
    ]
)]
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout uspešan'
        ]);
    }
}
