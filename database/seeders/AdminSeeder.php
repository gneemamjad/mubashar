<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Spatie\Permission\Models\Role as ModelsRole;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $roles = ModelsRole::all();

        // Create 50 admin records
        for ($i = 0; $i < 50; $i++) {

            \App\Models\Admin::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'status' => 'active',
                'phone' => '1234567890',
                'address' => 'Admin Address',
            ]);


        
        }
    }
}
