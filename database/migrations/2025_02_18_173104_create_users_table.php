<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->text('bio')->nullable();
            $table->string('profile_image')->nullable();
            $table->json('display_preferences')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('twitter_handle')->nullable();
            $table->string('facebook_handle')->nullable();
            $table->string('linkedin_handle')->nullable();
            $table->string('website')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->enum('role', ['admin', 'user'])->default('user'); // Role column
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
