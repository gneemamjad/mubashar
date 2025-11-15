<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::all();
        if(count($category) > 0)
            return;
        $realEstate = Category::create([
            'name' => [
                'en' => 'Real Estate',
                'ar' => 'عقارات',
            ],
            'icon' => 'http://127.0.0.1:8000/storage/images/house.png',
        ]);

        $residential = Category::create([
            'name' => [
                'en' => 'Residential',
                'ar' => 'منازل',
            ],

        ]);
        $residential->makeChildOf($realEstate);

        $forSale = Category::create([
            'name' => [
                'en' => 'For Sale',
                'ar' => 'للبيع',
            ],

        ]);
        $forSale->makeChildOf($residential);

        $flat = Category::create([
            'name' => [
                'en' => 'Flat',
                'ar' => 'شقة',
            ],

        ]);
        $flat->makeChildOf($forSale);

        $luxuryApartment = Category::create([
            'name' => [
                'en' => 'Luxury Apartment',
                'ar' => 'شقة سوبر لوكس',
            ],

        ]);
        $luxuryApartment->makeChildOf($forSale);

        $villa = Category::create([
            'name' => [
                'en' => 'Villa',
                'ar' => 'فيلا',
            ],

        ]);
        $villa->makeChildOf($forSale);

        $forRent = Category::create([
            'name' => [
                'en' => 'For Rent',
                'ar' => 'للإيجار',
            ],

        ]);
        $forRent->makeChildOf($residential);

        $touristicRentals = Category::create([
            'name' => [
                'en' => 'Touristic Rentals',
                'ar' => 'إيجارات ترفيهية',
            ],

        ]);
        $touristicRentals->makeChildOf($residential);

        $flatForRent = Category::create([
            'name' => [
                'en' => 'Flat',
                'ar' => 'شقة',
            ],

        ]);
        $flatForRent->makeChildOf($forRent);

        $luxuryApartmentForRent = Category::create([
            'name' => [
                'en' => 'Luxury Apartment',
                'ar' => 'شقة سوبر لوكس',
            ],

        ]);
        $luxuryApartmentForRent->makeChildOf($forRent);

        $villaForRent = Category::create([
            'name' => [
                'en' => 'Villa',
                'ar' => 'فيلا',
            ],

        ]);
        $villaForRent->makeChildOf($forRent);

        $withAssests = Category::create([
            'name' => [
                'en' => 'With Assests',
                'ar' => 'مع الأصول',
            ],

        ]);
        $withAssests->makeChildOf($residential);

        $commercial = Category::create([
            'name' => [
                'en' => 'Commercial',
                'ar' => 'تجاري',
            ],

        ]);
        $commercial->makeChildOf($realEstate);

        $land = Category::create([
            'name' => [
                'en' => 'Land',
                'ar' => 'أرض',
            ],

        ]);
        $land->makeChildOf($realEstate);



        $vehicles = Category::create([
            'name' => [
                'en' => 'Vehicles',
                'ar' => 'مركبات',
            ],
            'icon' => 'http://127.0.0.1:8000/storage/images/steering-wheel.png',
        ]);

        $cars = Category::create([
            'name' => [
                'en' => 'Cars',
                'ar' => 'سيارات',
            ],

        ]);
        $cars->makeChildOf($vehicles);

        $motorcycles = Category::create([
            'name' => [
                'en' => 'Motorcycles',
                'ar' => 'دراجات نارية',
            ],

        ]);
        $motorcycles->makeChildOf($vehicles);

        $trucks = Category::create([
            'name' => [
                'en' => 'Trucks',
                'ar' => 'شاحنات',
            ],

        ]);
        $trucks->makeChildOf($vehicles);

        $minivans = Category::create([
            'name' => [
                'en' => 'Minivans',
                'ar' => 'فان',
            ],

        ]);
        $minivans->makeChildOf($vehicles);



    }
}
