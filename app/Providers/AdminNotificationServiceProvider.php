<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AdminNotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.admin', function ($view) {
            $notifications = \App\Models\Order::where('status', 'processing')->latest()->limit(5)->get();
            $view->with('notifications', $notifications);
        });
    }
}
