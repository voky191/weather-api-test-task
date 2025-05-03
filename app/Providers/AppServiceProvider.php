<?php

namespace App\Providers;

use App\Contracts\WeatherService;
use App\Services\Weather\ApiService;
use App\Services\Weather\ResultService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(WeatherService::class, ResultService::class);

        $this->app->bind(ApiService::class, function () {
            return new ApiService(
                uri: config('weather.uri'),
                apiKey:config('weather.api_key')
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
