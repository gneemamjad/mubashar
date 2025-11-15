<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create 50 users
        for ($i = 0; $i < 50; $i++) {
            User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'user_name' => $faker->unique()->userName,
                'email' => $faker->unique()->safeEmail,
                'mobile' => $faker->unique()->numerify('##########'), // 10 digit number
                'password' => Hash::make('password123'), // default password
                'app_version' => $faker->semver, // generates version numbers like "2.0.1"
                'otp' => $faker->numerify('####'), // 4 digit OTP
                'active' => $faker->boolean(80), // 80% chance of being active
                'blocked' => $faker->boolean(20), // 20% chance of being blocked
                'email_verified_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }
    }
} 