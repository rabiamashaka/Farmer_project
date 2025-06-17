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
    Schema::create('market_prices', function (Blueprint $table) {
        $table->id();
        $table->string('crop');
        $table->string('location');
        $table->decimal('price_per_kg', 10, 2);
        $table->string('currency', 10);
        $table->date('market_date');
        $table->string('source');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_price');
    }
};
