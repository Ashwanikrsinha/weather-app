<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use App\Http\Requests\SearchCityRequest;
use App\Http\Requests\WeatherByCoordinatesRequest;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function searchCity(SearchCityRequest $request)
    {
        $query = $request->validated()['query'];

        try {
            $locations = $this->weatherService->searchCityByName($query);
            return response()->json($locations);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getWeatherByCoordinates(WeatherByCoordinatesRequest $request)
    {
        $validatedData =  $validated = $request->validated();
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
