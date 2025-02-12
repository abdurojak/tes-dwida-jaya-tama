<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route untuk menyimpan user
Route::post('/users', [UserController::class, 'store']);

// Route untuk login
Route::post('/login', [AuthController::class, 'login']);

// Route yang memerlukan autentikasi JWT
Route::middleware('jwt.auth')->group(
    function () {

        // Route untuk menyimpan post
        Route::post('/posts', [PostController::class, 'store']);

        // Route untuk mencari posts milik user
        Route::get('/users/{id}/posts', [UserController::class, 'getUserPosts']);

        // Route untuk mencari posts berdasarkan keyword
        Route::get('/posts', [PostController::class, 'index']);

        // Route untuk menghapus user berdasarkan id
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
    }
);
