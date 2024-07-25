<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RegistrationService;

class RegistrationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(RegistrationService::class, function () {
            return new RegistrationService();
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
