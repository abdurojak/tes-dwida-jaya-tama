<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Nama tabel
    protected $table = 'users';

    // Mengatur item yang bisa diisi
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Mengatur item yang disembunyikan
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi ke tabel post
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }
}
