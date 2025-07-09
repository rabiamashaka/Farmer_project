<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
     Schema::create('weather_readings', function (Blueprint $table) {
    $table->id(); // BIGINT UNSIGNED PRIMARY KEY
 $table->unsignedBigInteger('region_id');

 

 $table->float('temperature');
 $table->integer('humidity');
    $table->float('wind');
    $table->float('rain')->nullable();
    $table->timestamp('measured_at');
    $table->timestamps();
});




    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_readings');
    }
};
