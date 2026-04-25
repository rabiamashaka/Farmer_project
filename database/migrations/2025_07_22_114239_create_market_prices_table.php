<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketPricesTable extends Migration
{
   public function up()
{
    if (!Schema::hasTable('market_prices')) {
        Schema::create('market_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crop_id')->nullable(); // optional
            $table->unsignedBigInteger('region_id');
            $table->integer('price_per_kg');
            $table->string('currency')->default('TSh');
            $table->date('market_date');
            $table->string('source')->nullable();
            $table->timestamps();
        });
    }
}


    public function down()
    {
        Schema::dropIfExists('market_prices');
    }
}
