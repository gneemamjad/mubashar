<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ads = Ad::all();
        foreach ($ads as $ad) {
            Media::create([
                'ad_id' => $ad->id,
                'type' => 1,
                'active' => 1,
                'name' => 'no_image.jpeg',
            ]);
        }
    }
}
