<?php

namespace Greeate\Greeate\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadService
{
    protected string $disk;

    public function __construct()
    {
        $this->disk = config('greeate.upload.disk', 'public');
    }

    public function upload(UploadedFile $file, string $directory = 'uploads'): string
    {
        $this->validateFile($file);
        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();

        return $file->storeAs($directory, $filename, $this->disk);
    }

    public function uploadImage(UploadedFile $file, string $directory = 'images', bool $thumbnails = false): array
    {
        $path = $this->upload($file, $directory);
        $result = ['original' => $path];

        if ($thumbnails && function_exists('imagecreatefromstring')) {
            foreach (config('greeate.upload.thumbnails', []) as $size => $dimensions) {
                $result[$size] = $this->createThumbnail($file, $directory, $dimensions);
            }
        }

        return $result;
    }

    public function delete(?string $path): bool
    {
        if (! $path) {
            return false;
        }

        return Storage::disk($this->disk)->delete($path);
    }

    protected function validateFile(UploadedFile $file): void
    {
        $maxSize = config('greeate.upload.max_size', 5120) * 1024;
        $allowed = array_merge(
            config('greeate.upload.allowed_images', []),
            config('greeate.upload.allowed_files', [])
        );

        if ($file->getSize() > $maxSize) {
            throw new \InvalidArgumentException('File size exceeds maximum allowed.');
        }

        if (! in_array(strtolower($file->getClientOriginalExtension()), $allowed, true)) {
            throw new \InvalidArgumentException('File type not allowed.');
        }
    }

    protected function createThumbnail(UploadedFile $file, string $directory, array $dimensions): string
    {
        $filename = Str::uuid().'_thumb.'.$file->getClientOriginalExtension();
        $path = "{$directory}/{$filename}";
        Storage::disk($this->disk)->put($path, file_get_contents($file->getRealPath()));

        return $path;
    }
}
