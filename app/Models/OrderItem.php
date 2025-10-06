<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Izinkan semua kolom diisi
    protected $guarded = [];

    // Satu item dimiliki oleh satu order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Satu item merujuk ke satu produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}