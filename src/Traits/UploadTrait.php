<?php

namespace Greeate\Greeate\Traits;

use Greeate\Greeate\Services\UploadService;
use Illuminate\Http\UploadedFile;

trait UploadTrait
{
    protected function uploadFile(UploadedFile $file, string $directory = 'uploads'): string
    {
        return app(UploadService::class)->upload($file, $directory);
    }

    protected function uploadImage(UploadedFile $file, string $directory = 'images', bool $thumbnails = true): array
    {
        return app(UploadService::class)->uploadImage($file, $directory, $thumbnails);
    }

    protected function deleteUploadedFile(?string $path): void
    {
        if ($path) {
            app(UploadService::class)->delete($path);
        }
    }
}
