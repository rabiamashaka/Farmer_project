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
        Schema::table('market_prices', function (Blueprint $table) {
            // Drop old string columns
            $table->dropColumn(['crop', 'location']);

            // Add foreign keys
            $table->unsignedBigInteger('crop_id')->after('id');
            $table->unsignedBigInteger('region_id')->after('crop_id');

            $table->foreign('crop_id')->references('id')->on('crops')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('market_prices', function (Blueprint $table) {
            $table->dropForeign(['crop_id']);
            $table->dropForeign(['region_id']);

            $table->dropColumn(['crop_id', 'region_id']);

            $table->string('crop')->nullable();
            $table->string('location')->nullable();
        });
    }
};
