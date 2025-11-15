<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ad_plan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ad_id');
            $table->bigInteger('plan_id');
            $table->index('ad_id');
            $table->index('plan_id');
            $table->timestamp('featured_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ad_plan');
    }
};
