<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;
    public $tries = 3;
    public $backoff = [10, 30];

    public function __construct(
        public string $imagePath, 
        public array $sizes = ['thumb' => [150, 150], 'medium' => [400, 400]]
    ) {}

    public function handle(): void
    {
        $absolutePath = public_path($this->imagePath);

        if (!file_exists($absolutePath)) {
            Log::warning("Image not found for processing: {$absolutePath}");
            return;
        }

        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($absolutePath);

            $pathInfo = pathinfo($absolutePath);
            $dirname = $pathInfo['dirname'];
            $filename = $pathInfo['filename'];
            $extension = $pathInfo['extension'];


            foreach ($this->sizes as $label => [$width, $height]) {
                $resized = $image->cover($width, $height, 'center');
                $newPath = "{$dirname}/{$filename}-{$label}.{$extension}";
                
                $resized->save($newPath, 85);
                Log::info("Variant created: {$newPath}");
            }


            $image->save($absolutePath, 85);

        } catch (\Exception $e) {
            Log::error("Image processing failed: " . $e->getMessage());

        }
    }
}