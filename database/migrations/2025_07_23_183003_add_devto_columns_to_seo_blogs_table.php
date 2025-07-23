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
        Schema::table('seo_blogs', function (Blueprint $table) {
            $table->string('devto_id')->nullable()->after('canonical_url');
            $table->string('devto_url')->nullable()->after('devto_id');
            $table->timestamp('devto_published_at')->nullable()->after('devto_url');
            
            // Add index for devto_id for faster queries
            $table->index('devto_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_blogs', function (Blueprint $table) {
            $table->dropIndex(['devto_id']);
            $table->dropColumn(['devto_id', 'devto_url', 'devto_published_at']);
        });
    }
};