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
    Schema::create('crop_advices', function (Blueprint $table) {
        $table->id();
        $table->foreignId('crop_id')->constrained()->onDelete('cascade');
        $table->string('type'); // kupanda, umwagiliaji, uvunaji, uhifadhi
        $table->string('title');
        $table->text('description');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_advice');
    }
};
