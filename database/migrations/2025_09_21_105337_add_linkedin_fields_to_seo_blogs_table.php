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
            $table->string('linkedin_id')->nullable()->after('devto_published_at');
            $table->timestamp('linkedin_published_at')->nullable()->after('linkedin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_blogs', function (Blueprint $table) {
            $table->dropColumn(['linkedin_id', 'linkedin_published_at']);
        });
    }
};