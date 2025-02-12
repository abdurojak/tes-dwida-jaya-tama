<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use App\Models\User;

class AuthController extends Controller
{
    // Fungsi login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Jika user tidak ditemukan atau password salah
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Buat payload JWT
        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + (60 * 60)
        ];

        // Generate token JWT
        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        return response()->json(['token' => $token]);
    }
}
