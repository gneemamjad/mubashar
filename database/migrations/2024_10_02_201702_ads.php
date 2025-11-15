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
        Schema::create('ad', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 1 for realstate, 2 for cars
            $table->integer('approved')->default(0);
            $table->text('description')->nullable();
            $table->integer('price');
            $table->integer('active')->default(1);
            $table->integer('category_id');
            $table->integer('status'); // 1 for rent, 2 rented, 3 for sale, 4 soled
            $table->integer('paid');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        // Find and drop all foreign keys referencing the 'ad' table
        $foreignKeys = $this->getForeignKeysReferencingTable('ad');
        foreach ($foreignKeys as $foreignKey) {
            Schema::table($foreignKey->TABLE_NAME, function (Blueprint $table) use ($foreignKey) {
                $table->dropForeign([$foreignKey->COLUMN_NAME]);
            });
        }
        Schema::dropIfExists('ad');
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
