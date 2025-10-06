<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    // TAMBAHKAN BARIS INI BIAR GAK KENA OMEL SATPAM
    protected $guarded = [];
}
