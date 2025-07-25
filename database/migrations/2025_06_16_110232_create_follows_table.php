<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
         if (!Schema::hasTable('follows')) {
            Schema::create('follows', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('follower_id');
                $table->unsignedBigInteger('following_id');
                $table->timestamps();
                
                $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('following_id')->references('id')->on('users')->onDelete('cascade');
                
                $table->unique(['follower_id', 'following_id']);
                $table->index(['follower_id', 'following_id']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('follows');
    }
};
