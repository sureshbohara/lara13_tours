<?php

declare(strict_types=1);

namespace App\Services\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class MediaService
{
    public function uploadImage(UploadedFile $file, string $directory = 'settings'): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        
      
        if (in_array($extension, ['jfif', 'pjpeg', 'jpeg', 'pjp'], true)) {
            $extension = 'jpg';
        }

        $filename = time() . '_' . Str::random(8) . '.' . $extension;
        $targetDirectory = public_path('images/' . $directory);

        if (!File::exists($targetDirectory)) {
            File::makeDirectory($targetDirectory, 0755, true);
        }

        $file->move($targetDirectory, $filename);
        $relativePath = $directory . '/' . $filename;

  
        $this->processImageVariants($relativePath);

        return $relativePath;
    }

    private function processImageVariants(string $path): void
    {
        $absolutePath = public_path('images/' . ltrim($path, '/'));
        
        if (!file_exists($absolutePath)) {
            return;
        }

        try {
            $extension = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));
            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                return;
            }

           
            $manager = new ImageManager(['driver' => 'gd']);
            $original = $manager->make($absolutePath);

            $directory = dirname($absolutePath);
            $filename = pathinfo($absolutePath, PATHINFO_FILENAME);

            $sizes = [
                'thumb'  => [150, 150],
                'medium' => [400, 400],
            ];

            foreach ($sizes as $label => $dimensions) {
                [$width, $height] = $dimensions;

        
                $image = clone $original;
                
           
                $image->fit($width, $height, function ($constraint) {
                    $constraint->upsize();
                }, 'center');

                $newPath = "{$directory}/{$filename}-{$label}.{$extension}";
                $image->save($newPath, 85); // Quality 85
            }

        } catch (\Throwable $e) {
            Log::error('Synchronous image processing failed', [
                'path' => $path,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function deleteImageVariants(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        $absolutePath = public_path('images/' . ltrim($path, '/'));

        if (File::exists($absolutePath)) {
            File::delete($absolutePath);
        }

        $pathInfo = pathinfo($absolutePath);
        $dirname = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];

        foreach (['thumb', 'medium'] as $size) {
            $variantPath = "{$dirname}/{$filename}-{$size}.{$extension}";
            if (File::exists($variantPath)) {
                File::delete($variantPath);
            }
        }
    }
}