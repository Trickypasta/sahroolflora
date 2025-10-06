<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * TAMBAHKAN BAGIAN INI
     * Otomatis ubah kolom-kolom ini jadi tipe data yang benar.
     */
    protected $casts = [
        'published_at' => 'datetime', // Ubah jadi objek Tanggal & Waktu (Carbon)
    ];

    // Relasi ke user (penulis)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}