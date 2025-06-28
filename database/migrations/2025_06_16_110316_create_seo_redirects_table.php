<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
         Schema::create('seo_redirects', function (Blueprint $table) {
            $table->id();
            $table->string('from_url');
            $table->string('to_url');
            $table->integer('status_code')->default(301); // 301, 302, 303, 307, 308
            $table->enum('type', ['manual', 'automatic'])->default('manual');
            $table->integer('hits')->default(0);
            $table->timestamp('last_hit')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('created_by');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('seos');
            $table->index('from_url');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_redirects');
    }
};
