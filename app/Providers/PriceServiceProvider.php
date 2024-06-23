<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PriceService;

class PriceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PriceService::class, function() {
            return new PriceService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
