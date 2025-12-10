<?php

namespace App\Services\Media;

use App\Abstracts\BaseMediaStorageService;
use App\Contracts\Services\MediaStorageServiceInterface;
use App\Enums\StorageDiskType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class S3Storage extends BaseMediaStorageService implements MediaStorageServiceInterface
{
    protected StorageDiskType $disk;

    public function __construct()
    {
        parent::__construct(StorageDiskType::S3);
    }

    /**
     * Resize image (DISABLED — no GD/Imagick needed)
     *
     * This version uploads the file directly to S3
     * without resizing or using Intervention/Image.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param int $width
     * @param int $height
     * @return void
     */
    protected function resizeImage(UploadedFile $file, string $directory, int $width, int $height): void
    {
        // Ensure directory format is correct
        $directory = trim($directory, '/');

        // Build full S3 path
        $path = $directory . '/' . $file->hashName();

        // Upload original file content to S3
        Storage::disk(strtolower($this->disk->label()))
            ->put($path, file_get_contents($file->getRealPath()));

        // DONE — no resizing, no GD, no Imagick.
        return;
    }
}
