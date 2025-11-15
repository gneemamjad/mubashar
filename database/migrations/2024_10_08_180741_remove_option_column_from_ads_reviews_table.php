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
        Schema::table('ads_reviews', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['review_option_id']);

            $table->dropColumn('review_option_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads_reviews', function (Blueprint $table) {
            // Add the column back
            $table->unsignedBigInteger('review_option_id')->nullable();

            // Recreate the foreign key constraint
            $table->foreign('review_option_id')->references('id')->on('review_options')->onDelete('set null');
        });
    }
};
