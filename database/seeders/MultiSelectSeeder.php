<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MultiSelectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('ad_attributes')->insert([
        //     'ad_id' => 1,
        //     'attribute_id' => 6,
        //     'created_at' => '2024-10-11 10:45:05',
        //     'updated_at' => '2024-10-11 10:45:05',
        //     'value' => ''
        // ]);

        // DB::table('ad_attributes_options')->insert([
        //     [
        //         'ad_attribute_id' => 6,
        //         'ad_attribute_option_id' => 2,
        //         'created_at' => '2024-10-11 10:45:05',
        //         'updated_at' => '2024-10-11 10:45:05'
        //     ],
        //     [
        //         'ad_attribute_id' => 6,
        //         'ad_attribute_option_id' => 1,
        //         'created_at' => '2024-10-11 10:45:05',
        //         'updated_at' => '2024-10-11 10:45:05'
        //     ]
        // ]);

        DB::table('categories_attributes')->insert([
            'category_id' => 1,
            'attribute_id' => 6,
            'filter_enabled' => 1,
            'created_at' => null,
            'updated_at' => null
        ]);
    }
}
