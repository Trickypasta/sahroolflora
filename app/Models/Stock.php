<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * TAMBAHKAN METHOD INI
     * Mendefinisikan bahwa satu stok dimiliki oleh satu produk.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}