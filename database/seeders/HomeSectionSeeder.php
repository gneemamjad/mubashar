<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeSection;

class HomeSectionSeeder extends Seeder
{
    public function run()
    {

        if (HomeSection::count() > 0) {
            return;
        }

        $sections = [
            [
                'name' => [
                    'en' => 'Favorites',
                    'ar' => 'المفضلة',
                ],
                'url' => '/home-favorites',
                'active' => true,
                'view_type' => 'horizontal',
                'queue' => 1,
                'limit' => 5,
            ],
            [
                'name' => [
                    'en' => 'Nearby Ads',
                    'ar' => 'الإعلانات القريبة',
                ],
                'url' => '/nearby-ads',
                'active' => true,
                'view_type' => 'vertical',
                'queue' => 2,
                'limit' => 5,
            ],
            [
                'name' => [
                    'en' => 'Most Viewed Ads',
                    'ar' => 'الإعلانات الأكثر مشاهدة',
                ],
                'url' => '/most-viewed-ads',
                'active' => true,
                'view_type' => 'horizontal',
                'queue' => 3,
                'limit' => 5,
            ],
            [
                'name' => [
                    'en' => 'Last Seen Ads',
                    'ar' => 'الإعلانات الأخيرة المشاهدة من قبلك',
                ],
                'url' => '/last-seen-ads',
                'active' => true,
                'view_type' => 'horizontal',
                'queue' => 4,
                'limit' => 5,
            ],
        ];

        foreach ($sections as $section) {
            HomeSection::create($section);
        }
    }
}
