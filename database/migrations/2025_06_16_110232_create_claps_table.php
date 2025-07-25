<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('claps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('seo_blog_id')->constrained()->onDelete('cascade');
            $table->integer('count')->default(1);
            $table->timestamps();

            $table->unique(['user_id', 'seo_blog_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('claps');
    }
};
