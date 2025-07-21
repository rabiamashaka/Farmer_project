<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crop_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crop_id');
            $table->string('type'); // e.g., 'tip', 'pest_control', 'design'
            $table->string('title');
            $table->text('description');
            $table->string('image_path')->nullable();
            $table->timestamps();
            $table->foreign('crop_id')->references('id')->on('crops')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('crop_information');
    }
}; 