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
        Schema::create('reel_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reel_id'); // Define the ad_id column
            $table->foreign('reel_id')->references('id')->on('reels')->onDelete('cascade');
            $table->index('reel_id');
            $table->unsignedBigInteger('user_id'); // Define the ad_id column
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reel_likes');
    }
};
