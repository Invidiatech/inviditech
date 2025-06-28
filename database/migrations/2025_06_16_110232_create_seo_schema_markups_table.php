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
          Schema::create('seo_schema_markups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // Organization, Product, Article, etc.
            $table->json('schema_data');
            $table->json('pages')->nullable(); // Which pages to apply to
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('created_by');
            $table->enum('validation_status', ['valid', 'invalid', 'pending'])->default('pending');
            $table->json('validation_errors')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('seos');
            $table->index('type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_schema_markups');
    }
};
