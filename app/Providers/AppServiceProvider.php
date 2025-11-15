<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Passport::ignoreRoutes();

        $this->app->bind(
            \App\Contracts\Repositories\ReportRepositoryInterface::class,
            \App\Repositories\ReportRepository::class
        );

        $this->app->bind(
            \App\Contracts\Services\ReportServiceInterface::class,
            \App\Services\ReportService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        self::isMaintenanceMode();
            
        // Force HTTPS only in production
        if (App::environment('production')) {
            URL::forceScheme('https');
        }
    }

    public function isMaintenanceMode(){
        if(env('MAINTAINANCE_MODE')){
            return response()->json(['message' => __('ads.maintenance')], 503);
        }
    }   

}
