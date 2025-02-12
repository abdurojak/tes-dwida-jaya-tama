<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next): JsonResponse
    {
        try {
            // Ambil token dari header Authorization
            $token = $request->bearerToken();

            // Jika token tidak ada
            if (!$token) {
                return response()->json(['message' => 'Token not provided'], 401);
            }

            // Decode token JWT
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            // Simpan user_id ke request untuk digunakan di controller
            $request->attributes->set('user_id', $decoded->sub);
        } catch (Exception $e) {

            // Message yang muncul ketika ada error atau token kadaluarsa
            return response()->json(['message' => 'Invalid or expired token'], 401);
        }

        return $next($request);
    }
}
