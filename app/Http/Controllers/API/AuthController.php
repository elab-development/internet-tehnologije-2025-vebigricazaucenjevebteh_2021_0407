<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Korisnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class AuthController extends Controller
{
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

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout uspešan'
        ]);
    }
}
