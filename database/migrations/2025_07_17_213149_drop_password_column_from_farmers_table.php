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
    Schema::table('farmers', function (Blueprint $table) {
        $table->dropColumn('password');
    });
}

public function down(): void
{
    Schema::table('farmers', function (Blueprint $table) {
        $table->string('password')->after('phone');
    });
}
};