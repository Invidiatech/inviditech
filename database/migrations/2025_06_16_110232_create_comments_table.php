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
        if (!Schema::hasTable('comments')) {
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('seo_blog_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->text('content');
                $table->boolean('is_approved')->default(true);
                $table->timestamps();
                $table->softDeletes();
                
                $table->foreign('seo_blog_id')->references('id')->on('seo_blogs')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
                
                $table->index(['seo_blog_id', 'is_approved']);
                $table->index('parent_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['seo_blog_id']);
            
            // Rename back to article_id
            $table->renameColumn('seo_blog_id', 'article_id');
        });
    }
};