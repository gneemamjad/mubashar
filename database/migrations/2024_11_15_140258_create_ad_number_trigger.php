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
    public function up()
    {
        // DB::unprepared('
        //     CREATE TRIGGER generate_ad_number AFTER INSERT ON ad
        //     FOR EACH ROW
        //     BEGIN
        //         DECLARE formatted_number VARCHAR(255);
        //         SET formatted_number = CONCAT(
        //             DATE_FORMAT(NOW(), "%y"),
        //             DATE_FORMAT(NOW(), "%m"),
        //             DATE_FORMAT(NOW(), "%d"),
        //             LPAD(NEW.id, 4, "0")
        //         );

        //         UPDATE ad
        //         SET ad_number = formatted_number
        //         WHERE id = NEW.id;
        //     END
        // ');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // DB::unprepared('DROP TRIGGER IF EXISTS generate_ad_number');
    }
};
