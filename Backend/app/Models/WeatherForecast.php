<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherForecast extends Model
{
    use HasFactory;
    protected $fillable = [
        'city_id', 'temperature', 'feels_like', 'temp_min', 'temp_max', 'pressure', 'humidity',
        'wind_speed', 'sea_level', 'grnd_level', 'visibility', 'cloud_percent', 'main_description',
        'description', 'sunrise', 'sunset', 'data_time', 'weather_data'
    ];


    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
