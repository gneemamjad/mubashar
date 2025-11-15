<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPersonalInfoToAdsTable extends Migration
{
    public function up()
    {
        Schema::table('ad', function (Blueprint $table) {
            $table->integer('show_as')->default(1);
        });
    }

    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['show_as']);
        });
    }
}
