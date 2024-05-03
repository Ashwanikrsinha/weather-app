<?php

namespace App\Services;

use App\Models\City;
use App\Models\WeatherForecast;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected $apiBaseUrl;
    protected $apiKey;
    protected $cacheDuration = 600; // Cache duration in seconds (10 minutes )

    public function __construct()
    {
        $this->apiBaseUrl = config('services.weather_api.base_url');
        $this->apiKey = config('services.weather_api.api_key');
    }

    public function searchCityByName($query)
    {
        // Attempt to find the city in the local database by name
        $city = City::where('name', $query)->first();

        if ($city) {
            // City data found in the database, return the dataset
            return $this->getCityData($query);
        }

        // City data not found in the database, fetch from the external API
        $cacheKey = "city_search_{$query}";

        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($query) {
            // Make HTTP GET request to the location API endpoint
            $response = Http::get("{$this->apiBaseUrl}/geo/1.0/direct", [
                'q' => $query,
                'limit' => 10,
                'appid' => $this->apiKey,
            ]);

            // Check if request was successful
            if ($response->successful()) {
                $locations = $response->json();

                // Process and store locations in the database
                foreach ($locations as $location) {
                    $this->storeCityData($location);
                }

                // Return the list of locations
                return $this->getCityData($query); // Retrieve and return from the database
            }

            // Handle API request failure
            throw new \Exception('Failed to fetch city data from the API.');
        });
    }

    protected function getCityData($query)
    {
        // Fetch the city data from the database
        return City::where('name', $query)->get();
    }

    protected function storeCityData($location)
    {
        // Check if the city already exists in the database
        $city = City::where('name', $location['name'])->first();

        if (!$city) {
            // Create a new city record
            $city = City::create([
                'name' => $location['name'],
                'country' => $location['country'],
                'state' => $location['state'] ?? null,
                'latitude' => $location['lat'],
                'longitude' => $location['lon'],
            ]);
        }

        // Update city coordinates if necessary
        if ($city->latitude !== $location['lat'] || $city->longitude !== $location['lon']) {
            $city->update([
                'latitude' => $location['lat'],
                'longitude' => $location['lon'],
            ]);
        }
    }

    public function getWeatherByCoordinates($latitude, $longitude)
    {
        $cacheKey = "weather_{$latitude}_{$longitude}";

        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($latitude, $longitude) {
            // Fetch weather data from the OpenWeatherMap weather API
            $response = Http::get("{$this->apiBaseUrl}/data/2.5/weather", [
                'lat' => $latitude,
                'lon' => $longitude,
                'appid' => $this->apiKey,
                'units' => 'metric',
            ]);

            // Check if request was successful
            if ($response->successful()) {
                $weatherData = $response->json();

                // Store weather forecast in the database
                $this->storeWeatherData($weatherData);

                return $weatherData;
            }

            // Handle API request failure
            throw new \Exception('Failed to fetch weather data from the API.');
        });
    }
    protected function storeWeatherData($weatherData)
    {
        $cityName = $weatherData['name'];
        $country = $weatherData['sys']['country'];
        $latitude = $weatherData['coord']['lat'];
        $longitude = $weatherData['coord']['lon'];
        $temperature = $weatherData['main']['temp'];
        $feelsLike = $weatherData['main']['feels_like'];
        $tempMin = $weatherData['main']['temp_min'];
        $tempMax = $weatherData['main']['temp_max'];
        $pressure = $weatherData['main']['pressure'];
        $humidity = $weatherData['main']['humidity'];
        $windSpeed = $weatherData['wind']['speed'];
        $seaLevel = $weatherData['main']['sea_level'] ?? null;
        $grndLevel = $weatherData['main']['grnd_level'] ?? null;
        $visibility = $weatherData['visibility'] ?? null;
        $cloudPercent = $weatherData['clouds']['all'] ?? null;
        $mainDescription = $weatherData['weather'][0]['main'] ?? null;
        $description = $weatherData['weather'][0]['description'] ?? null;

        // Convert Unix timestamps to Carbon instances for readable dates/times
        $sunrise = isset($weatherData['sys']['sunrise']) ? Carbon::createFromTimestampUTC($weatherData['sys']['sunrise']) : null;
        $sunset = isset($weatherData['sys']['sunset']) ? Carbon::createFromTimestampUTC($weatherData['sys']['sunset']) : null;
        $dataTime = isset($weatherData['dt']) ? Carbon::createFromTimestampUTC($weatherData['dt']) : null;

        // Find or create the associated city based on name
        $city = City::firstOrCreate(['name' => $cityName], [
            'name' => $cityName,
            'country' => $country,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        // Update or create the weather forecast for the city
        $city->weatherForecast()->updateOrCreate(
            [],
            [
                'temperature' => $temperature,
                'feels_like' => $feelsLike,
                'temp_min' => $tempMin,
                'temp_max' => $tempMax,
                'pressure' => $pressure,
                'humidity' => $humidity,
                'wind_speed' => $windSpeed,
                'sea_level' => $seaLevel,
                'grnd_level' => $grndLevel,
                'visibility' => $visibility,
                'cloud_percent' => $cloudPercent,
                'main_description' => $mainDescription,
                'description' => $description,
                'sunrise' => $sunrise,
                'sunset' => $sunset,
                'data_time' => $dataTime,
                'weather_data' => $weatherData, // Store the entire weather data in JSON format if needed
            ]
        );
    }

}
