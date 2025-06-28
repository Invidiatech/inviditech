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
          Schema::create('seo_robots', function (Blueprint $table) {
            $table->id();
            $table->longText('content');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('last_updated_by');
            $table->enum('validation_status', ['valid', 'invalid', 'pending'])->default('pending');
            $table->json('validation_errors')->nullable();
            $table->timestamps();

            $table->foreign('last_updated_by')->references('id')->on('seos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_robots');
    }
};
