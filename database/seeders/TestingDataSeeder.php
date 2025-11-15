<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestingDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $ads = Ad::all();
        if(count($ads) > 0)
            return;


            DB::table('users')->insert([
                [
                    'id' => null,
                    'first_name' => 'ameen',
                    'last_name' => 'kayed',
                    'mobile' => '962298812',
                    'email' => null,
                    'verified_at' => '2024-10-04 12:44:05',
                    'otp' => '243073',
                    'remember_token' => null,
                    'created_at' => '2024-10-02 23:00:52',
                    'updated_at' => '2024-10-04 15:37:56',
                    'call' => '1',
                    'notification' => '1',
                    'image' => 'no_photo.jpg',
                ],
                [
                    'id' => null,
                    'first_name' => '',
                    'last_name' => '',
                    'mobile' => '962298815',
                    'email' => null,
                    'verified_at' => '2024-10-04 14:25:18',
                    'otp' => null,
                    'remember_token' => null,
                    'created_at' => '2024-10-04 14:23:10',
                    'updated_at' => '2024-10-04 14:25:18',
                    'call' => '1',
                    'notification' => '1',
                    'image' => null,
                ],
                [
                    'id' => null,
                    'first_name' => 'malek',
                    'last_name' => 'deghlawi',
                    'mobile' => '937058954',
                    'email' => null,
                    'verified_at' => '2024-10-04 12:44:05',
                    'otp' => '112233',
                    'remember_token' => null,
                    'created_at' => '2024-10-02 23:00:52',
                    'updated_at' => '2024-10-04 15:37:56',
                    'call' => '1',
                    'notification' => '1',
                    'image' => 'no_photo.jpg',
                ],
            ]);

            DB::table('city')->insert([
                [
                    'id' => null,
                    'name' => json_encode(['ar' => 'دمشق', 'en' => 'Damascus']),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'active' => '1',
                ],
                [
                    'id' => null,
                    'name' => json_encode(['ar' => 'حلب', 'en' => 'Aleppo']),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'active' => '1',
                ],
            ]);

            DB::table('area')->insert([
                [
                    'id' => null,
                    'name' => json_encode(['ar' => 'برامكة', 'en' => 'Baramkeh']),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'city_id' => '1',
                    'active' => '1',
                ],
                [
                    'id' => null,
                    'name' => json_encode(['ar' => 'صوفانية', 'en' => 'Sofaneah']),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'city_id' => '2',
                    'active' => '1',
                ],
            ]);

        DB::table('ad')->insert([
            [
                'id' => null,
                'title' => json_encode(['ar' => 'شقة طابق رابع', 'en' => 'Flat floor 4']),
                'type' => '1',
                'approved' => '1',
                'description' => json_encode(['ar' => 'شقة طابق رابع مكسية كسوة كاملة مساحة 120 متر', 'en' => 'Fourth floor apartment, fully finished, area 120 square meters']),
                'price' => '484654',
                'active' => '1',
                'category_id' => '4',
                'status' => '1',
                'paid' => '1',
                'lat'=>'33.494004',
                'lng'=>'36.296125',
                'verified_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => '1',
                'city_id' => '1',
                'area_id' => '1',
                'image' => 'cover.jpg',
            ],
            [
                'id' => null,
                'title' => json_encode(['ar' => 'رينو ميغان', 'en' => 'renault megane']),
                'type' => '2',
                'approved' => '1',
                'description' => json_encode(['ar' => 'سيارة كاملة', 'en' => 'full car']),
                'price' => '2500000',
                'active' => '1',
                'category_id' => '16',
                'status' => '1',
                'paid' => '1',
                'lat'=>'33.499909',
                'lng'=>'36.294666',
                'verified_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => '1',
                'city_id' => '2',
                'area_id' => '2',
                'image' => null,
            ],
            [
                'id' => null,
                'title' => json_encode(['ar' => 'محضر', 'en' => 'mahdar']),
                'type' => '1',
                'approved' => '1',
                'description' => json_encode(['ar' => 'محضر كامل مع طاقة شمسية مؤلف من 10 طوابق', 'en' => 'Fully furnished 10 storey solar powered building']),
                'price' => '484654',
                'active' => '1',
                'category_id' => '14',
                'status' => '1',
                'paid' => '1',
                'lat'=>'33.503917',
                'lng'=>'36.277585',
                'verified_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => '1',
                'city_id' => '1',
                'area_id' => '1',
                'image' => null,
            ],
            [
                'id' => null,
                'title' => json_encode(['ar' => 'كيا ريو', 'en' => 'kia rio']),
                'type' => '2',
                'approved' => '1',
                'description' => json_encode(['ar' => 'سيارة كاملة', 'en' => 'full car']),
                'price' => '2500000',
                'active' => '1',
                'category_id' => '16',
                'status' => '1',
                'paid' => '1',
                'lat' => '33.505778',
                'lng' => '36.262479',
                'verified_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => '1',
                'city_id' => '2',
                'area_id' => '2',
                'image' => null,
            ],
        ]);

        DB::table('attribute_view_list_type')->insert([
            [
                'id' => null,
                'name' => json_encode(['ar' => 'عام', 'en' => 'Static']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => null,
                'name' => json_encode(['ar' => 'مميز', 'en' => 'Featured']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $nameAttribute = Attribute::create([
            'key' => ['en' => 'name', 'ar' => 'الاسم'],
            'value' => '',
            'type' => 'text',
            'created_at' => now(),
            'updated_at' => now(),
            'list_type_id' => 1
        ]);
        $addressAttribute = Attribute::create([
            'key' => ['en' => 'address', 'ar' => 'العنوان'],
            'value' => '',
            'type' => 'text',
            'created_at' => now(),
            'updated_at' => now(),
            'list_type_id' => 1
        ]);
        $sizeAttribute = Attribute::create([
            'key' => ['en' => 'size', 'ar' => 'المساحة'],
            'value' => null,
            'type' => 'select',
            'created_at' => now(),
            'updated_at' => now(),
            'list_type_id' => 1
        ]);

        $sizeAttribute->attributeOptions()->create([
            'key' =>['en' => '1', 'ar' => '1'],
            'value' => null,
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $sizeAttribute->attributeOptions()->create([
            'key' => ['en' => '2', 'ar' => '2'],
            'value' => null,
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $sizeAttribute->attributeOptions()->create([
            'key' =>['en' => '3', 'ar' => '3'],
            'value' => null,
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $balconyAttribute = Attribute::create([
            'key' => ['en' => 'balcony', 'ar' => 'البلكون'],
            'value' => null,
            'type' => 'select',
            'created_at' => now(),
            'updated_at' => now(),
            'list_type_id' => 1
        ]);

        $balconyAttribute->attributeOptions()->create([
            'key' =>['en' => 'Yes', 'ar' => 'نعم'],
            'value' => null,
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $balconyAttribute->attributeOptions()->create([
            'key' => ['en' => 'No', 'ar' => 'لا'],
            'value' => null,
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // $leaves = Category::allLeaves()->get();
        // foreach ($leaves as $key => $value) {
        //     $value->attributes()->attach($nameAttribute->id);
        //     $value->attributes()->attach($addressAttribute->id);
        //     $value->attributes()->attach($sizeAttribute->id);
        // }


        DB::table('ad_attributes')->insert([
            [
                'id' => null,
                'ad_id' => '1',
                'attribute_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
                'value' => 'test 1',
            ],
            [
                'id' => null,
                'ad_id' => '1',
                'attribute_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
                'value' => 'test 2',
            ],
            [
                'id' => null,
                'ad_id' => '1',
                'attribute_id' => '3',
                'created_at' => now(),
                'updated_at' => now(),
                'value' => '',
            ],
        ]);


        DB::table('ad_attributes_options')->insert([
            [
                'id' => null,
                'ad_attribute_id' => '2',
                'ad_attribute_option_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('media')->insert([
            [
                'id' => null,
                'type' => '1',
                'name' => 'main.jpg',
                'ad_id' => '1',
                'active' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => null,
                'type' => '2',
                'name' => 'main.mp4',
                'ad_id' => '1',
                'active' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


        DB::table('favorites')->insert([
            [
                'id' => null,
                'ad_id' => '1',
                'user_id' => '1',
                'created_at' => '2024-10-05 15:05:02',
                'updated_at' => '2024-10-05 00:00:00',
            ],
        ]);

        DB::table('price_history')->insert([
            [
                'id' => null,
                'ad_id' => '1',
                'old_price' => '88484',
                'new_price' => '484654',
                'discount' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => null,
                'ad_id' => '1',
                'old_price' => '88484',
                'new_price' => '484654',
                'discount' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
