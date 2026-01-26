<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Korisnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'ime' => 'required|string|max:255',
            'email' => 'required|email|unique:korisniks,email',
            'password' => 'required|string|min:6|confirmed',
            'tip_korisnika' => 'nullable|in:registrovani,editor,administrator',
        ]);

        $korisnik = Korisnik::create([
            'ime' => $validated['ime'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'tip_korisnika' => $validated['tip_korisnika'] ?? 'registrovani',
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

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $korisnik = Korisnik::where('email', $validated['email'])->first();

        if (!$korisnik || !Hash::check($validated['password'], $korisnik->password)) {
            throw ValidationException::withMessages([
                'email' => ['Pogrešan email ili lozinka.'],
            ]);
        }

        // opciono: obriši stare tokene
        $korisnik->tokens()->delete();

        $token = $korisnik->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login uspešan',
            'korisnik' => [
                'id' => $korisnik->id,
                'ime' => $korisnik->ime,
                'email' => $korisnik->email,
                'tip_korisnika' => $korisnik->tip_korisnika,
            ],
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout uspešan'
        ]);
    }
}
