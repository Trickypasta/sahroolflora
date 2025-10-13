<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            // Tambahkan product_id setelah order_id.
            // Bisa null agar data lama tidak error. onDelete('set null') artinya jika produk dihapus, ulasannya tetap ada tapi product_id jadi null.
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null')->after('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            //
        });
    }
};
