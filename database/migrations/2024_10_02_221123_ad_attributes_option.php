<?php

use App\Models\AdAttribute;
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
        Schema::create('attributes_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_id'); // Define the ad_id column
            $table->index('attribute_id');
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
            $table->string('key');
            $table->string('value')->nullable();
            $table->integer('active')->default();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes_options');
    }
};
