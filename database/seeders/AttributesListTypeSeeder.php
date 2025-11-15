<?php

namespace Database\Seeders;

use App\Models\AttributeViewListType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributesListTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        AttributeViewListType::create([
            'name' => [
                "ar" => "مميز",
                "en" => "Fetcherd"
            ]
        ]);

        AttributeViewListType::create([
            'name' => [
                "ar" => "عام",
                "en" => "Static"
            ]
        ]);
    }
}
