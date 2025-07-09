<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weather_readings', function (Blueprint $table) {
            // kama haipo bado, ongeza rain & wind hapa pia
            // $table->float('wind')->nullable()->after('humidity');
            // $table->float('rain')->nullable()->after('wind');

            // Columns mpya
            $table->string('condition')->nullable()->after('rain');
            $table->string('source')->nullable()->after('condition');
        });
    }

    public function down(): void
    {
        Schema::table('weather_readings', function (Blueprint $table) {
            $table->dropColumn(['condition', 'source']);
        });
    }
};
