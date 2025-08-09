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
        Schema::create('website_analytics', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('device_type')->nullable(); // mobile, desktop, tablet
            $table->string('browser')->nullable();
            $table->string('operating_system')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('referrer')->nullable();
            $table->string('landing_page')->nullable();
            $table->string('current_page')->nullable();
            $table->integer('page_views')->default(1);
            $table->integer('session_duration')->default(0); // in seconds
            $table->boolean('is_bot')->default(false);
            $table->json('utm_parameters')->nullable();
            $table->timestamps();
            
            $table->index(['created_at', 'device_type']);
            $table->index(['created_at', 'country']);
            $table->index(['session_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_analytics');
    }
};