<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    // Kasih izin biar bisa diisi massal
    protected $guarded = [];

    // Definisikan relasi bahwa alamat ini dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}