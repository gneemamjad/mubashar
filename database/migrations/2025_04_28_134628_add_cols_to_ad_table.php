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
        Schema::table('ad', function (Blueprint $table) {
            $table->integer('highlighter')->default(0)->after('paid');
            $table->integer('sold')->default(0)->after('paid');
            $table->integer('rented')->default(0)->after('paid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ad', function (Blueprint $table) {
            $table->dropColumn('highlighter');
            $table->dropColumn('sold');
            $table->dropColumn('rented');
        });
    }
};
