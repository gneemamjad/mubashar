<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('app_details')->insert([
            [
                'key' => 'about',
                'value' => json_encode([
                    'en' => '<div><h1>About Us</h1><p>Welcome to our platform! We are dedicated to providing the best marketplace experience for our users.</p><p>Our mission is to connect buyers and sellers in an easy and efficient way.</p></div>',
                    'ar' => '<div><h1>معلومات عنا</h1><p>مرحباً بكم في منصتنا! نحن ملتزمون بتقديم أفضل تجربة سوق لمستخدمينا.</p><p>مهمتنا هي ربط المشترين والبائعين بطريقة سهلة وفعالة.</p></div>'
                ]),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'help_guide',
                'value' => json_encode([
                    'en' => '<div><h1>Help Guide</h1><h2>Getting Started</h2><ul><li>Create an account</li><li>Browse categories</li><li>Post your first ad</li><li>Contact sellers</li></ul><h2>Safety Tips</h2><ul><li>Meet in public places</li><li>Verify seller information</li><li>Report suspicious activity</li></ul></div>',
                    'ar' => '<div><h1>دليل المساعدة</h1><h2>البدء</h2><ul><li>إنشاء حساب</li><li>تصفح الفئات</li><li>نشر إعلانك الأول</li><li>تواصل مع البائعين</li></ul><h2>نصائح الأمان</h2><ul><li>قابل في الأماكن العامة</li><li>تحقق من معلومات البائع</li><li>الإبلاغ عن النشاط المشبوه</li></ul></div>'
                ]),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
