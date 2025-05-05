<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WeatherController;
use App\Http\Middleware\CheckWeatherApiKey;

Route::get('/weather', [WeatherController::class, 'search'])
    ->middleware(CheckWeatherApiKey::class)
    ->name('weather.search');
