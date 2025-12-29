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

        // Share settings globally
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $dateFormat = \App\Models\Setting::get('date_format', 'd/m/Y');
                $currencyFormat = \App\Models\Setting::get('currency_format', 'idr');

                \Illuminate\Support\Facades\View::share('appDateFormat', $dateFormat);
                \Illuminate\Support\Facades\View::share('appCurrencyFormat', $currencyFormat);
            } else {
                 \Illuminate\Support\Facades\View::share('appDateFormat', 'd/m/Y');
                 \Illuminate\Support\Facades\View::share('appCurrencyFormat', 'idr');
            }
        } catch (\Exception $e) {
            // Fallback
             \Illuminate\Support\Facades\View::share('appDateFormat', 'd/m/Y');
             \Illuminate\Support\Facades\View::share('appCurrencyFormat', 'idr');
        }
    }
}
