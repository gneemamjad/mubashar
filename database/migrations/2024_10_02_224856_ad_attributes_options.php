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
        Schema::create('ad_attributes_options', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ad_attribute_id'); // Define the ad_id column
            $table->index('ad_attribute_id');
            $table->foreign('ad_attribute_id')->references('id')->on('ad_attributes')->onDelete('cascade');

            $table->unsignedBigInteger('ad_attribute_option_id'); // Define the ad_id column
            $table->index('ad_attribute_option_id');
            $table->foreign('ad_attribute_option_id')->references('id')->on('attributes_options')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_attributes_options');
    }
};
