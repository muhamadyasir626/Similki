<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once base_path('app\helpers.php');

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        
    }
}
