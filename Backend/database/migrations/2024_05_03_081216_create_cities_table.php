<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country');
            $table->string('state')->nullable();
            $table->double('latitude', 10, 6);
            $table->double('longitude', 10, 6);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cities');
    }
}

