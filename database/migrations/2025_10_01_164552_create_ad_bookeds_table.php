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
        Schema::create('ad_bookeds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ad_id');
            $table->timestamp('date')->nullable();
            $table->foreign('ad_id')->references('id')->on('ad')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_bookeds');
    }
};
