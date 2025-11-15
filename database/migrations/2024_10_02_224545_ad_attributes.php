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
        Schema::create('ad_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ad_id'); // Define the ad_id column
            $table->index('ad_id');
            $table->foreign('ad_id')->references('id')->on('ad')->onDelete('cascade');
            $table->unsignedBigInteger('attribute_id'); // Define the ad_id column
            $table->index('attribute_id');
            $table->foreign('attribute_id')->references('id')->on('ad_attributes')->onDelete('cascade');
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_attributes');
    }

};
