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
        Schema::create('ads_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ad_id');
            $table->index('ad_id');
            $table->foreign('ad_id')->references('id')->on('ad')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('review_option_id');
            $table->index('review_option_id');
            $table->foreign('review_option_id')->references('id')->on('review_options')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads_reviews');
    }
};
