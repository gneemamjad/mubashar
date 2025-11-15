<?php

namespace Database\Seeders;

use App\Models\ReviewOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = ReviewOption::all();
        if(count($options) > 0)
            return;

        $option = ReviewOption::create([
            'text' => [
                'en' => 'The product/service specified in the advertisement has been sold or rented',
                'ar' => 'تم بيع أو تأجير المنتج/الخدمة المحددة في الإعلان',
            ],
            'active' => 1,
            'created_at' => now()
        ]);

        $option = ReviewOption::create([
            'text' => [
                'en' => 'Ad category is incorrect',
                'ar' => 'فئة الإعلان غير صحيحة',
            ],
            'active' => 1,
            'created_at' => now()
        ]);

        $option = ReviewOption::create([
            'text' => [
                'en' => 'Ad information is incorrect or false',
                'ar' => 'معلومات الإعلان غير صحيحة أو خاطئة',
            ],
            'active' => 1,
            'created_at' => now()
        ]);

        $option = ReviewOption::create([
            'text' => [
                'en' => 'The ad has been published more than once',
                'ar' => 'تم نشر الإعلان أكثر من مرة',
            ],
            'active' => 1,
            'created_at' => now()
        ]);
    }
}
