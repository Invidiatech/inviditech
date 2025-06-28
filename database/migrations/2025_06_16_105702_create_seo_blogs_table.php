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
        Schema::create('seo_blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->longText('content');
            $table->text('excerpt')->nullable();
            $table->boolean('is_indexed')->default(true);
            $table->boolean('is_featured')->default(false); // Added
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt')->nullable(); // Added
            $table->enum('status', ['draft', 'published', 'scheduled'])->default('draft');
            $table->timestamp('publish_date')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            $table->json('schema_markup')->nullable();
            $table->unsignedBigInteger('created_by');
            
            // Changed from string to foreign key
            $table->unsignedBigInteger('category')->nullable();
            
            $table->integer('seo_score')->default(0);
            $table->json('seo_analysis')->nullable(); // Added
            $table->string('focus_keyword')->nullable();
            $table->integer('readability_score')->default(0);
            $table->integer('reading_time')->default(0);
            $table->unsignedInteger('views_count')->default(0); // Added
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign key constraints
            $table->foreign('created_by')->references('id')->on('seos');
            $table->foreign('category')->references('id')->on('categories')->onDelete('set null');
            
            // Indexes
            $table->index('slug');
            $table->index('category');
            $table->index('status');
            $table->index('is_featured');
            $table->index('publish_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_blogs');
    }
};