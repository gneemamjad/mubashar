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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 1 for images, 2 for videos, 3 for 360' images
            $table->string('name'); // Changed integer to string based on the name field usage.
            $table->unsignedBigInteger('ad_id'); // Define the ad_id column
            $table->index('ad_id');
            $table->foreign('ad_id')->references('id')->on('ad')->onDelete('cascade');
            $table->integer('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }

};
