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
        // database/migrations/xxxx_xx_xx_create_sms_campaigns_table.php
Schema::create('sms_campaigns', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('message');
    $table->json('locations')->nullable();
    $table->json('crops')->nullable();
    $table->string('language')->nullable();
    $table->integer('recipients')->default(0);
    $table->integer('sent')->default(0);
    $table->integer('delivered')->default(0);
    $table->integer('failed')->default(0);
    $table->string('status')->default('draft');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_campaigns');
    }
};
