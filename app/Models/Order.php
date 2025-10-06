<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Izinkan semua kolom diisi
    protected $guarded = [];

    // Satu order dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Satu order punya satu alamat pengiriman
    public function address()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    // Satu order punya banyak item
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function testimonial()
    {
        return $this->hasOne(Testimonial::class);
    }

    public function returnRequest() { return $this->hasOne(ReturnRequest::class); }

}
