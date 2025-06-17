<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::create('weather', function (Blueprint $table) {
        $table->id();
        $table->string('location');
        $table->float('temperature');
        $table->float('humidity');
        $table->float('rainfall');
        $table->string('condition');
        $table->date('date');
        $table->string('source');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather');
    }
};
