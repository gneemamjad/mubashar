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
        DB::unprepared('
            CREATE FUNCTION calc_distance(
                lat1 FLOAT,
                lng1 FLOAT,
                lat2 FLOAT,
                lng2 FLOAT
            ) RETURNS FLOAT
            NO SQL
            DETERMINISTIC
            RETURN 111.111 * DEGREES(
                ACOS(
                    LEAST(
                        1.0,
                        COS(RADIANS(lat1)) * COS(RADIANS(lat2)) * COS(
                            RADIANS(lng1 - lng2)
                        ) + SIN(RADIANS(lat1)) * SIN(RADIANS(lat2))
                    )
                )
            )
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS calc_distance');
    }
};
