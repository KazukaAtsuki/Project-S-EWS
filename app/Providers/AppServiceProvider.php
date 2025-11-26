<?php

namespace App\Providers;

use App\Models\MonitoringLog;
use App\Observers\MonitoringLogObserver;
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
        // Register MonitoringLog Observer
        MonitoringLog::observe(MonitoringLogObserver::class);
    }
}

