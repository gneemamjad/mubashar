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
        Schema::table('ad', function(Blueprint $table)
        {
            $table->index('type');
            $table->index('approved');
            $table->index('price');
            $table->index('active');
            $table->index('category_id');
            $table->index('status');
            $table->index('paid');
            $table->index('created_at');
        });

        Schema::table('area', function(Blueprint $table)
        {
            $table->index('active');
        });

        Schema::table('attributes', function(Blueprint $table)
        {
            $table->index('ad_type');
            $table->index('type');
        });

        Schema::table('attributes_options', function(Blueprint $table)
        {
            $table->index('active');
        });

        Schema::table('media', function(Blueprint $table)
        {
            $table->index('type');
            $table->index('active');
        });





    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
