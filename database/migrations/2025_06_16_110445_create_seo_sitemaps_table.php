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
        Schema::create('seo_sitemaps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['pages', 'blogs', 'products', 'categories', 'custom'])->default('pages');
            $table->json('urls');
            $table->json('settings')->nullable(); // For frequency, priority, etc.
            $table->timestamp('last_generated')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('file_path')->nullable();
            $table->integer('total_urls')->default(0);
            $table->boolean('submitted_to_google')->default(false);
            $table->timestamp('google_submission_date')->nullable();
            $table->string('google_submission_status')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('seos');
            $table->index('type');
            $table->index('status');
            $table->index('last_generated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_sitemaps');
    }
};
