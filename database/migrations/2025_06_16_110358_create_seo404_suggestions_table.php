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
      Schema::create('seo404_suggestions', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('referer')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('ip_address')->nullable();
            $table->integer('hits')->default(1);
            $table->timestamp('last_hit');
            $table->string('suggested_redirect')->nullable();
            $table->enum('status', ['pending', 'resolved', 'ignored'])->default('pending');
            $table->timestamp('resolved_at')->nullable();
            $table->unsignedBigInteger('resolved_by')->nullable();
            $table->timestamps();

            $table->foreign('resolved_by')->references('id')->on('seos');
            $table->index('url');
            $table->index('status');
            $table->index('last_hit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo404_suggestions');
    }
};
