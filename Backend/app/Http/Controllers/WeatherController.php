<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function searchCity(Request $request)
    {
        $validatedData = $request->validate([
            'query' => 'required|string|max:255', // 'query' parameter is required and must be a string (maximum length 255)
        ]);

        $query = $validatedData['query'];

        try {
            $locations = $this->weatherService->searchCityByName($query);
            return response()->json($locations);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getWeatherByCoordinates(Request $request)
    {
        $validatedData = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $latitude = $validatedData['latitude'];
        $longitude = $validatedData['longitude'];

        try {
            $weatherData = $this->weatherService->getWeatherByCoordinates($latitude, $longitude);
            return response()->json($weatherData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
