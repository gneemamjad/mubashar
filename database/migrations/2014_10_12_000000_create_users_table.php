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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile')->unique();
            $table->string('email')->unique()->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('otp')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        // Find and drop all foreign keys referencing the 'users' table
        $foreignKeys = $this->getForeignKeysReferencingTable('users');
        foreach ($foreignKeys as $foreignKey) {
            Schema::table($foreignKey->TABLE_NAME, function (Blueprint $table) use ($foreignKey) {
                $table->dropForeign([$foreignKey->COLUMN_NAME]);
            });
        }
        Schema::dropIfExists('users');
    }

    private function getForeignKeysReferencingTable($tableName)
    {
        return DB::select("
            SELECT TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE REFERENCED_TABLE_SCHEMA = ?
              AND REFERENCED_TABLE_NAME = ?
        ", [env('DB_DATABASE'), $tableName]);
    }
};
