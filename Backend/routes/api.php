<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

// Fetch city dropdown
Route::get('/search-city', [WeatherController::class, 'searchCity']);
// Fetch weather by cordinates
Route::get('/weather-by-coordinates', [WeatherController::class, 'getWeatherByCoordinates']);
