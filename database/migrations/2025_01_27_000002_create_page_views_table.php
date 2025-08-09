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
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->string('url')->index();
            $table->string('page_title')->nullable();
            $table->string('page_type')->nullable(); // home, article, service, etc.
            $table->unsignedBigInteger('article_id')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('referrer')->nullable();
            $table->integer('time_on_page')->default(0); // in seconds
            $table->integer('scroll_depth')->default(0); // percentage
            $table->json('utm_parameters')->nullable();
            $table->timestamps();
            
            $table->index(['created_at', 'page_type']);
            $table->index(['article_id', 'created_at']);
            $table->index(['url', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};