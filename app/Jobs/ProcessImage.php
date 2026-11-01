<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use RuntimeException;
use Throwable;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 120;
    public int $tries = 3;
    public array $backoff = [10, 30];

    public function __construct(
        public string $imagePath,
        public array $sizes = [
            'thumb'  => [150, 150],
            'medium' => [400, 400],
        ]
    ) {}

    public function handle(): void
    {
        $absolutePath = public_path('images/' . ltrim($this->imagePath, '/'));
        $imageRoot = realpath(public_path('images'));
        $realPath = realpath($absolutePath);

        if (
            !$imageRoot ||
            !$realPath ||
            !is_file($realPath) ||
            !str_starts_with($realPath, $imageRoot . DIRECTORY_SEPARATOR)
        ) {
            Log::warning('Invalid or missing image', ['path' => $this->imagePath]);
            return;
        }

        try {
            $extension = strtolower(pathinfo($realPath, PATHINFO_EXTENSION));

            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                throw new RuntimeException('Unsupported image format.');
            }

            $manager = new ImageManager(new Driver());
            $original = $manager->read($realPath);

            $directory = dirname($realPath);
            $filename = pathinfo($realPath, PATHINFO_FILENAME);

            foreach ($this->sizes as $label => $dimensions) {
                if (
                    !is_string($label) ||
                    !preg_match('/^[a-zA-Z0-9_-]+$/', $label) ||
                    !is_array($dimensions) ||
                    count($dimensions) !== 2
                ) {
                    throw new RuntimeException('Invalid image variant configuration.');
                }

                [$width, $height] = $dimensions;

                if (!is_int($width) || !is_int($height) || $width < 1 || $height < 1) {
                    throw new RuntimeException('Invalid image dimensions.');
                }

                $image = clone $original;
                $image->cover($width, $height, 'center');

                $newPath = "{$directory}/{$filename}-{$label}.{$extension}";
                $image->save($newPath, quality: 85);

                Log::info('Image variant generated', [
                    'path' => $newPath,
                    'size' => $label,
                ]);
            }

        } catch (Throwable $e) {
            Log::error('Image processing failed', [
                'path' => $this->imagePath,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}