<?php

namespace App\Console\Commands;

use App\Models\Media;
use Illuminate\Console\Command;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class WatermarkOldImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:watermark-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apply watermark to old images';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $manager = new ImageManager(new Driver());
        $waterMarkManager = new ImageManager(new Driver());

        $watermarkPath = public_path('watermark.png');
        $tempWatermarkPath = public_path('new-watermark.png');

        if (!file_exists($watermarkPath)) {
            $this->error('Watermark image not found!');
            return;
        }

        $watermark = $waterMarkManager->read($watermarkPath)->resize(600, 400);
        $watermark->save($tempWatermarkPath);

        $images = Media::where('type', MEDIA_TYPES['image'])->where('id','>','4099')->get();
        $this->info("Found {$images->count()} images to watermark.");

        foreach ($images as $index => $media) {
            $path = storage_path('app/public/uploads/images/' . $media->name);

            if (!file_exists($path)) {
                $this->warn("File not found: {$media->name}");
                continue;
            }

            $img = $manager->read($path);
            $img->place($tempWatermarkPath, 'center', 0, 0, 25);
            $img->save($path);

            $this->info("Watermarked: {$media->name}");
        }

        $this->info('✅ Watermarking complete.');
    }
}
