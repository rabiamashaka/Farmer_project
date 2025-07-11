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
        // database/migrations/xxxx_xx_xx_create_sms_logs_table.php
Schema::create('sms_logs', function (Blueprint $table) {
    $table->id();
    $table->string('phone');
    $table->text('message');
    $table->string('status')->default('pending'); // sent, delivered, failed
    $table->timestamp('sent_at')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};
