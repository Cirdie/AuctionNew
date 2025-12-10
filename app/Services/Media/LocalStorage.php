<?php

namespace App\Services\Media;

use App\Abstracts\BaseMediaStorageService;
use App\Contracts\Services\MediaStorageServiceInterface;
use App\Enums\StorageDiskType;
use Illuminate\Http\UploadedFile;

class LocalStorage extends BaseMediaStorageService implements MediaStorageServiceInterface
{
    public function __construct()
    {
        parent::__construct(StorageDiskType::LOCAL);
    }

    /**
     * Resize image (DISABLED — no GD/Imagick needed).
     *
     * This version simply moves/uploads the file without resizing.
     * This prevents errors caused by missing PHP image libraries.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param int $width
     * @param int $height
     * @return void
     */
    protected function resizeImage(UploadedFile $file, string $directory, int $width, int $height): void
    {
        // Ensure directory does not start with "public"
        $directory = preg_replace('/^public/', '', $directory);

        // Build destination path
        $destination = storage_path('app/public' . $directory);

        // Make directory if missing
        if (!is_dir($destination)) {
            mkdir($destination, 0777, true);
        }

        // Move file as-is (no resize)
        $file->move($destination, $file->hashName());

        // DONE — no GD, no Imagick, no Intervention required.
        return;
    }
}
