<?php

namespace App\Strategies\Provider;

use App\Models\FileManagerMedia;
use App\Strategies\MediaStrategy;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class Photo implements MediaStrategy
{
    protected $imageManager;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }


    public function upload($file, $folder_id, $type): string
    {
        // Validate file type
//        $file->validate([
//            'media' => 'mimes:' . implode(',', config('filemanager.image.valid_mime')) . '|max:' . config('filemanager.image.max_size')
//        ]);

        // Prepare file data for storage
        $post = [
            'folder_id' => $folder_id,
            'name'      => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size'      => $file->getSize(),
        ];

        // Save file metadata to database
        $lastRecord = FileManagerMedia::create($post);

        // Generate new file name and store file
        $extension = $lastRecord->getExtensionFromMimeType($file->getMimeType());
        $newFileName = "{$lastRecord->id}.{$extension}";
        $uploadPath = "uploads/{$lastRecord->id}";
        $path = $file->storeAs($uploadPath, $newFileName, $this->getTypeUpload($type));
        $storedFilePath = Storage::path("{$this->getTypeUpload($type)}/{$path}");

        // Create thumbnails if enabled
        if (config('filemanager.image.thumbnail') && $this->getTypeUpload($type) == 'public') {
            $this->createThumbnails($storedFilePath, $lastRecord, $file);
        }

        return "File uploaded";
    }

    private function getTypeUpload($type): string
    {
        return $type === 'private' ? 'private' : 'public';
    }

    private function createThumbnails(string $storedFilePath, FileManagerMedia $lastRecord, $file)
    {
        foreach (config('filemanager.image.thumbnail_size') as $key => $thumb) {
            $size = explode('*', $thumb);
            $image = $this->imageManager->read($storedFilePath)
                ->resize($size[0], $size[1]);

            $thumbnailExtension = $lastRecord->getExtensionFromMimeType($file->getMimeType());
            $thumbnailFileName = "{$key}-{$lastRecord->id}.{$thumbnailExtension}";
            $thumbnailPath = "uploads/{$lastRecord->id}/{$thumbnailFileName}";

            Storage::put("public/{$thumbnailPath}", (string)$image->encode());
        }
    }

}
