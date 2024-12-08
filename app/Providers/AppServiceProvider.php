<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Reservation;
use App\Observers\ModelObserver;

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
        Reservation::observe(ModelObserver::class);
    }
}
