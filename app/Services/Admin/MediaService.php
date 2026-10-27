<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Jobs\ProcessImage;
use Illuminate\Http\UploadedFile;

class MediaService
{
    
    public function uploadImage(UploadedFile $file, string $directory = 'settings'): string
    {
        //jfif convert .jpg 
        $extension = strtolower($file->getClientOriginalExtension());
        if (in_array($extension, ['jfif', 'pjpeg', 'jpeg', 'pjp'])) {
            $extension = 'jpg';
        }

        $filename = time() . '_' . uniqid() . '.' . $extension;
        
        //Direct public path
        $targetDirectory = public_path('images/' . $directory);

        //  Folder Create
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        //  File move 
        $file->move($targetDirectory, $filename);
        return $directory . '/' . $filename; 
    }

    public function dispatchImageProcessing(string $path): void
    {
        ProcessImage::dispatch($path);
    }

    public function deleteImageVariants(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        $absolutePath = public_path($path);

        // Delete original image
        if (file_exists($absolutePath)) {
            unlink($absolutePath);
        }

        // Delete variants (thumb, medium)
        $pathInfo = pathinfo($absolutePath);
        $dirname = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];

        foreach (['thumb', 'medium'] as $size) {
            $variantPath = "{$dirname}/{$filename}-{$size}.{$extension}";
            if (file_exists($variantPath)) {
                unlink($variantPath);
            }
        }
    }
}