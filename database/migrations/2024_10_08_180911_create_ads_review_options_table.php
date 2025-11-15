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
        Schema::create('ads_review_options', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('review_id');
            $table->index('review_id');
            $table->foreign('review_id')->references('id')->on('ads_reviews')->onDelete('cascade');

            $table->unsignedBigInteger('option_id');
            $table->index('option_id');
            $table->foreign('option_id')->references('id')->on('review_options')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads_review_options');
    }
};
