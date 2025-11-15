<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'title' => [
                    'en' => 'Ad for 30 Days',
                    'ar' => 'إعلان لمدة 30 يوم',
                ],
                'description' => [
                    'en' => 'Price: 100,000 SP',
                    'ar' => 'السعر: 100,000 ل.س',
                ],
                'price' => 100000,
                'old_price' => 120000,
                'duration_days' => 30,
                'is_active' => true
            ],
            [
                'title' => [
                    'en' => 'Ad for 60 Days',
                    'ar' => 'إعلان لمدة 60 يوم',
                ],
                'description' => [
                    'en' => 'Price: 190,000 SP',
                    'ar' => 'السعر: 190,000 ل.س',
                ],
                'price' => 190000,
                'old_price' => 220000,
                'duration_days' => 60,
                'is_active' => true
            ],
            [
                'title' => [
                    'en' => 'Ad for 90 Days',
                    'ar' => 'إعلان لمدة 90 يوم',
                ],
                'description' => [
                    'en' => 'Price: 270,000 SP',
                    'ar' => 'السعر: 270,000 ل.س',
                ],
                'price' => 270000,
                'old_price' => 300000,
                'duration_days' => 90,
                'is_active' => true
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
