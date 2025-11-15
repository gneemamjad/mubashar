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
        Schema::create('reels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ad_id'); // Define the ad_id column
            $table->foreign('ad_id')->references('id')->on('ad')->onDelete('cascade');
            $table->index('ad_id');
            $table->unsignedBigInteger('user_id'); // Define the ad_id column
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('description'); 
            $table->string('reel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reels');
    }
};
