<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class CartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('partials.navbar', function ($view) {
            $cartCount = 0;
            $orderCount = 0; // Tambahkan variabel baru

            if (Auth::check()) {
                // Logika untuk hitung keranjang
                $cart = Auth::user()->cart;
                if ($cart) {
                    $cartCount = $cart->items->count(); // Pakai count() untuk jumlah item unik
                }

                // Logika BARU untuk hitung pesanan aktif
                $orderCount = Auth::user()->orders()
                    ->whereNotIn('status', ['completed', 'cancelled'])
                    ->count();
            }

            $view->with('cartCount', $cartCount);
            $view->with('orderCount', $orderCount); // Kirim data baru ke view
        });
    }
}
