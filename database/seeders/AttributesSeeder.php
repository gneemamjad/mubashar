<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('attributes')->truncate();
        DB::table('attributes_options')->truncate();


        $streetAtribute = Attribute::create([
            'key' => ['en' => 'Street', 'ar' => 'الشارع'],
            'value' => '',
            'type' => 'text',
            'created_at' => now(),
            'updated_at' => now(),
            'list_type_id' => 1,
            'required' => true,
        ]);
        $roomsNumberAttribute = Attribute::create([
            'key' => ['en' => 'Rooms number', 'ar' => 'عدد الغرف'],
            'value' => '',
            'type' => 'numeric',
            'created_at' => now(),
            'updated_at' => now(),
            'list_type_id' => 1,
            'required' => true,
        ]);
        $buildingTypeAttribute = Attribute::create([
            'key' => ['en' => 'Building type', 'ar' => 'نوع البناء'],
            'value' => '',
            'type' => 'select',
            'created_at' => now(),
            'updated_at' => now(),
            'list_type_id' => 1,
            'required' => true,
        ]);

        $alternativeEnergyAttribute = Attribute::create([
            'key' => ['en' => 'Alternative energy', 'ar' => 'طاقة بديلة'],
            'value' => '',
            'type' => 'boolean',
            'created_at' => now(),
            'updated_at' => now(),
            'list_type_id' => 1,
            'required' => true,
        ]);

        $releaseDateAttribute = Attribute::create([
            'key' => ['en' => 'Release Date', 'ar' => 'تاريخ العمار'],
            'value' => '',
            'type' => 'date',
            'created_at' => now(),
            'updated_at' => now(),
            'list_type_id' => 1,
            'required' => true,
        ]);

        $featuresAttribute = Attribute::create([
            'key' => ['en' => 'Features', 'ar' => 'الميزات'],
            'value' => '',
            'type' => 'multiselect',
            'created_at' => now(),
            'updated_at' => now(),
            'list_type_id' => 1,
            'required' => true,
        ]);

        $furnitureAttribute = Attribute::create([
            'key' => ['en' => 'Furniture', 'ar' => 'العفش'],
            'value' => '',
            'type' => 'radio',
            'created_at' => now(),
            'updated_at' => now(),
            'list_type_id' => 1,
            'required' => true,
        ]);

        $buildingTypeAttribute->attributeOptions()->create([
            'key' => ['en' => 'arabic', 'ar' => 'عربي'],
            'value' => null,
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $buildingTypeAttribute->attributeOptions()->create([
            'key' => ['en' => 'western', 'ar' => 'غربي'],
            'value' => null,
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $featuresAttribute->attributeOptions()->create([
            'key' => ['en' => 'Marble facade', 'ar' => 'واجهة رخامية'],
            'value' => null,
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $featuresAttribute->attributeOptions()->create([
            'key' => ['en' => 'Marble stairs', 'ar' => 'درج رخامية'],
            'value' => null,
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $furnitureAttribute->attributeOptions()->create([
            'key' => ['en' => 'Furnished', 'ar' => 'مفروش'],
            'value' => null,
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $furnitureAttribute->attributeOptions()->create([
            'key' => ['en' => 'Unfurnished', 'ar' => 'غير مفروش'],
            'value' => null,
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $leaves = Category::allLeaves()->get();
        foreach ($leaves as $key => $value) {
            $value->attributes()->attach($streetAtribute->id);
            $value->attributes()->attach($roomsNumberAttribute->id);
            $value->attributes()->attach($buildingTypeAttribute->id);
            $value->attributes()->attach($alternativeEnergyAttribute->id);
            $value->attributes()->attach($releaseDateAttribute->id);
            $value->attributes()->attach($featuresAttribute->id);
            $value->attributes()->attach($furnitureAttribute->id);
        }

        $overlookingPartiesAttribute = Attribute::create([
            'key' => [
                'en' => 'Overlooking parties',
                'ar' => 'الأطراف المطلة'
            ],
            'type' => 'multiselect',
            'created_at' => now(),
            'updated_at' => now(),
            'list_type_id' => 2,
        ]);

        $overlookingPartiesAttribute->attributeOptions()->createMany([
            ['key' => ['en' => 'East', 'ar' => 'شرق'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'West', 'ar' => 'غرب'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'North', 'ar' => 'شمال'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'South', 'ar' => 'جنوب'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $interiorFeaturesAttribute = Attribute::create([
            'key' => [
                'en' => 'Interior Features',
                'ar' => 'الميزات الداخلية'
            ],
            'type' => 'multiselect',
            'created_at' => now(),
            'updated_at' => now(),
            'list_type_id' => 2,
        ]);

        $interiorFeaturesAttribute->attributeOptions()->createMany([
            ['key' => ['en' => 'ADSL', 'ar' => 'ADSL'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Wood floor', 'ar' => 'أرضية خشبية'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Smart home', 'ar' => 'منزل ذكي'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Theft alarm device', 'ar' => 'جهاز إنذار السرقة'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Arabic toilet', 'ar' => 'مرحاض عربي'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Arabic toilet', 'ar' => 'مرحاض عربي'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $externalFeaturesAttribute = Attribute::create([
            'key' => [
                'en' => 'External features',
                'ar' => 'الميزات الخارجية'
            ],
            'type' => 'multiselect',
            'created_at' => now(),
            'updated_at' => now(),
            'list_type_id' => 2,
        ]);

        $externalFeaturesAttribute->attributeOptions()->createMany([
            ['key' => ['en' => 'Car Charger', 'ar' => 'شاحن سيارة'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Building Guard', 'ar' => 'حارس المبنى'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Swimming Pool', 'ar' => 'حمام سباحة'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Garden', 'ar' => 'حديقة'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Generator', 'ar' => 'مولد كهرباء'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Fire Stairs', 'ar' => 'سلالم الحريق'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $surroundingAttribute = Attribute::create([
            'key' => [
                'en' => 'Surrounding',
                'ar' => 'المحيط'
            ],
            'type' => 'multiselect',
            'created_at' => now(),
            'updated_at' => now(),
            'list_type_id' => 2,
        ]);

        $surroundingAttribute->attributeOptions()->createMany([
            ['key' => ['en' => 'Mosque', 'ar' => 'مسجد'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Church', 'ar' => 'كنيسة'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Municipality building', 'ar' => 'مبنى البلدية'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Elementary school', 'ar' => 'مدرسة ابتدائية'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'High school', 'ar' => 'مدرسة ثانوية'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Mall', 'ar' => 'مركز تسوق'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Pharmacy', 'ar' => 'صيدلية'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Hospital', 'ar' => 'مستشفى'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Police station', 'ar' => 'مركز شرطة'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $viewAttribute = Attribute::create([
            'key' => [
                'en' => 'View',
                'ar' => 'الإطلالة'
            ],
            'type' => 'multiselect',
            'created_at' => now(),
            'updated_at' => now(),
            'list_type_id' => 2,
        ]);

        $viewAttribute->attributeOptions()->createMany([
            ['key' => ['en' => 'Sea View', 'ar' => 'إطلالة على البحر'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Mountain View', 'ar' => 'إطلالة على الجبل'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Forest View', 'ar' => 'إطلالة على الغابة'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Pool View', 'ar' => 'إطلالة على المسبح'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'Garden View', 'ar' => 'إطلالة على الحديقة'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => ['en' => 'City View', 'ar' => 'إطلالة على المدينة'], 'value' => null, 'active' => '1', 'created_at' => now(), 'updated_at' => now()],
        ]);

        foreach ($leaves as $key => $value) {
            $value->attributes()->attach($overlookingPartiesAttribute->id);
            $value->attributes()->attach($interiorFeaturesAttribute->id);
            $value->attributes()->attach($externalFeaturesAttribute->id);
            $value->attributes()->attach($surroundingAttribute->id);
            $value->attributes()->attach($viewAttribute->id);
        }



    }
}
