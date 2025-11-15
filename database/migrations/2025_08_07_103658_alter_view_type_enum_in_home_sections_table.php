<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('home_sections', function (Blueprint $table) {
            DB::statement("ALTER TABLE home_sections MODIFY COLUMN view_type ENUM('horizontal', 'vertical', 'horizontal_scroll') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_sections', function (Blueprint $table) {
            DB::statement("ALTER TABLE home_sections MODIFY COLUMN view_type ENUM('horizontal', 'vertical') NOT NULL");
        });
    }
};
