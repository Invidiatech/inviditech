<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
         if (!Schema::hasTable('bookmarks')) {
            Schema::create('bookmarks', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('seo_blog_id');
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('seo_blog_id')->references('id')->on('seo_blogs')->onDelete('cascade');
                
                $table->unique(['user_id', 'seo_blog_id']);
                $table->index('seo_blog_id');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('bookmarks');
    }
};
