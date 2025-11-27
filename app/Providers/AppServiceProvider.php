<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share vehicle data with all views using drivvo layout
        view()->composer('layouts.drivvo', \App\View\Composers\VehicleComposer::class);
    }
}
