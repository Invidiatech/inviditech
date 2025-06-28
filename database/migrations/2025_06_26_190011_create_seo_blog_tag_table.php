<?php
// Create this migration: php artisan make:migration create_seo_blog_tag_table

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
        Schema::create('seo_blog_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seo_blog_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('seo_blog_id')->references('id')->on('seo_blogs')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            
            // Unique constraint to prevent duplicate relationships
            $table->unique(['seo_blog_id', 'tag_id']);
            
            // Indexes for better performance
            $table->index('seo_blog_id');
            $table->index('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_blog_tag');
    }
};