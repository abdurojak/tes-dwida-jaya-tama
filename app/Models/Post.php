<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'posts';

    // Mengatur item yang bisa diisi
    protected $fillable = ['title', 'body', 'user_id'];

    // Relasi ke tabel user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
