<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class UserController extends Controller
{
    /**
     * Store a newly created user in the database.
     */

    // Fungsi Penyimpanan
    public function store(Request $request): JsonResponse
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        // Jika validasi gagal, akan mengirim response error
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Simpan user ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Kembalikan response dengan status 201 tanpa password
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ], 201);
    }

    // Fungsi Mencari Post Berdasarkan User
    public function getUserPosts($id)
    {
        // Mengecek apakah user dengan ID yang diberikan ada
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        // Ambil semua postingan milik user
        $posts = $user->posts()->get();

        // Jika user tidak memiliki postingan
        if ($posts->isEmpty()) {
            return response()->json([
                'message' => 'No posts found for this user'
            ], 404);
        }

        // Kembalikan response dengan data postingan
        return response()->json($posts, 200);
    }

    public function destroy($id)
    {
        // Mulai transaksi
        DB::beginTransaction();

        try {
            // Cari user
            $user = User::find($id);

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            // Hapus semua postingan terkait
            Post::where('user_id', $id)->delete();

            // Hapus user
            $user->delete();

            // Commit transaksi
            DB::commit();

            return response()->json(['message' => 'User and related posts deleted successfully'], 200);
        } catch (\Exception $e) {
            // Rollback jika terjadi kesalahan
            DB::rollBack();

            // Mengirimkan status 500 dan pesan error
            return response()->json([
                'message' => 'Failed to delete user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
