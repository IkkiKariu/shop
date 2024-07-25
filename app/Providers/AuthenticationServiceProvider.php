<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AuthenticationService;

class AuthenticationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(AuthenticationService::class, function () {
            return new AuthenticationService();
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
