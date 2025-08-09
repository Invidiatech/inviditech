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
        Schema::create('search_console_data', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->string('page_url')->index();
            $table->string('query')->nullable();
            $table->integer('clicks')->default(0);
            $table->integer('impressions')->default(0);
            $table->decimal('ctr', 5, 4)->default(0); // Click-through rate
            $table->decimal('position', 5, 2)->default(0); // Average position
            $table->string('country')->nullable();
            $table->string('device')->nullable(); // mobile, desktop, tablet
            $table->timestamps();
            
            $table->unique(['date', 'page_url', 'query', 'country', 'device']);
            $table->index(['date', 'clicks']);
            $table->index(['date', 'impressions']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_console_data');
    }
};