<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Store a newly created post in the database.
     */

    // Fungsi menyimpan post
    public function store(Request $request): JsonResponse
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        // Jika validasi gagal, kirimkan response error
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Simpan post ke database
        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $request->user_id,
        ]);

        // Kembalikan response dengan status 201
        return response()->json([
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'user_id' => $post->user_id,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
        ], 201);
    }

    // Fungsi menampilkan posts
    public function index(Request $request)
    {
        // Ambil parameter pencarian dan paginasi dari query string
        $search = $request->query('search');
        $limit = $request->query('limit', 10); // Default 10 post per halaman

        // Query untuk mengambil postingan
        $query = Post::query();

        // Jika ada parameter 'search', filter berdasarkan title
        if (!empty($search)) {
            $query->where('title', 'like', "%{$search}%");
        }

        // Ambil data dengan paginasi
        $posts = $query->paginate($limit);

        // Kembalikan response JSON
        return response()->json($posts, 200);
    }
}
