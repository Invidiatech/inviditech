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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->text('message');
            $table->boolean('privacy')->default(false);
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->enum('status', ['unread', 'read', 'replied', 'archived'])->default('unread');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'created_at']);
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};