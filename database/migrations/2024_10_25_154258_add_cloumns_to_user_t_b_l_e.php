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
        Schema::table('users', function (Blueprint $table) {
            $table->integer("blocked")->after('otp')->default(0);
            $table->integer("active")->after('otp')->default(1);
            $table->integer("deleted")->after('otp')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
    }
};
