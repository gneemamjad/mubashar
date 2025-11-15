<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrenySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currency = Currency::create([
            'name' => [
                'en' => 'SYP',
                'ar' => 'ل.س',
            ],
            'active' => 1,
        ]);

        $currency = Currency::create([
            'name' => [
                'en' => '$',
                'ar' => '$',
            ],
            'active' => 1,
        ]);

        $currency = Currency::create([
            'name' => [
                'en' => 'AED',
                'ar' => 'د.ا',
            ],
            'active' => 1,
        ]);

    }
}
