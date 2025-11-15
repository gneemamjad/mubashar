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
        Schema::create('attribute_view_list_type', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Find and drop all foreign keys referencing this table
        $foreignKeys = $this->getForeignKeysReferencingTable('attribute_view_list_type');
        foreach ($foreignKeys as $foreignKey) {
            Schema::table($foreignKey->TABLE_NAME, function (Blueprint $table) use ($foreignKey) {
                $table->dropForeign([$foreignKey->COLUMN_NAME]);
            });
        }
        Schema::dropIfExists('attribute_view_list_type');
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
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
