<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt')->nullable();
            $table->string('status')->default('draft'); // draft, published, private
            $table->boolean('is_premium')->default(false); // for membership/paywall
            $table->boolean('is_featured')->default(false);
            $table->integer('reading_time')->nullable(); // in minutes
            $table->dateTime('published_at')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('canonical_url')->nullable();
            $table->json('schema_markup')->nullable(); // for custom schema.org markup
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Add indexes for better performance
            $table->index(['status', 'published_at']);
            $table->index(['is_featured', 'published_at']);
            $table->index(['is_premium', 'published_at']);
            $table->index('views_count');
            $table->index('likes_count');
            $table->fullText(['title', 'excerpt', 'content']); // for full-text search
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
};