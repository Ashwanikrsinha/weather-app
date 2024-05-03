<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherForecastsTable extends Migration
{
    public function up()
    {
        Schema::create('weather_forecasts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->float('temperature');
            $table->float('feels_like')->nullable();
            $table->float('temp_min')->nullable();
            $table->float('temp_max')->nullable();
            $table->integer('pressure')->nullable();
            $table->integer('humidity')->nullable();
            $table->float('wind_speed')->nullable();
            $table->integer('sea_level')->nullable();
            $table->integer('grnd_level')->nullable();
            $table->integer('visibility')->nullable();
            $table->float('cloud_percent')->nullable();
            $table->text('main_description')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('sunrise')->nullable();
            $table->timestamp('sunset')->nullable();
            $table->timestamp('data_time')->nullable();
            $table->json('weather_data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('weather_forecasts');
    }
}
