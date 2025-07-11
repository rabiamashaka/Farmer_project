<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');            // weather, pest, advice, n.k.
            $table->string('language', 2);         // sw / en
            $table->string('content', 160);        // SMS body
            $table->json('regions')->nullable();   // ["Dodoma","Mwanza"]
            $table->json('crops')->nullable();     // ["maize","rice"]
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->unsignedBigInteger('parent_id')->nullable(); // kufunga pair ya lugha
            $table->timestamps();

            // (hiari) index kwa kasi ya kutafuta
            $table->index('category');
            $table->index('language');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_templates');
    }
};
