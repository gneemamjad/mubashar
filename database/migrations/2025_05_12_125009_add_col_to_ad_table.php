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
            $table->unsignedBigInteger('added_by')->after('user_id')->nullable();
            $table->index('added_by');
            $table->foreign('added_by')->references('id')->on('admins')->onDelete('cascade');
            $table->unsignedBigInteger('approved_by')->nullable()->after('added_by');
            $table->index('approved_by');
            $table->foreign('approved_by')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ad', function (Blueprint $table) {
            $table->dropColumn('added_by');
            $table->dropColumn('approved_by');
        });
    }
};
