<?php

namespace App\Strategies\Provider;

use App\Models\FileManagerMedia;
use App\Strategies\MediaStrategy;
use Intervention\Image\ImageManager;

class Photo implements MediaStrategy
{

    public function upload($file, $folder_id): string
    {
        /*
        $rules['media'] = 'mimes:' . implode(',', config('filemanager.image.valid_mime')) . '|max:' . config('filemanager.image.max_size');
        $request->validate($rules);
     */
        $post = [
            'folder_id' => $folder_id,
            'name'      => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size'      => $file->getSize(),
        ];
        $lastRecord = FileManagerMedia::create($post);
        if ($file) {
            // گرفتن پسوند از mime type
            $extension = $this->getExtensionFromMimeType($file->getMimeType());
            // تنظیم نام جدید فایل به نام پوشه
            $newFileName = $lastRecord->id . '.' . $extension;
            $path = $file->storeAs('uploads/' . $lastRecord->id, $newFileName, 'public');
            $storedFilePath = storage_path('app/public/' . $path);
            if (config('filemanager.image.thumbnail')) {
                foreach (config('filemanager.image.thumbnail_size') as $key => $thumb) {
                    $image = ImageManager::gd()->read($storedFilePath);
                    $size = explode('*', $thumb);
                    $image->resize($size[0], $size[1]);
                    $thumbnailExtension = $this->getExtensionFromMimeType($file->getMimeType());
                    $thumbnailPath = 'uploads/' . $lastRecord->id . '/' . $key . "-" . $lastRecord->id . '.' . $thumbnailExtension;
                    $image->save(storage_path('app/public/' . $thumbnailPath));
                }
            }
            return "File uploaded";
        }
        return "File upload failed";
    }

    private function getExtensionFromMimeType($mimeType): string
    {
        $mimeMap = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif',
        ];

        return $mimeMap[$mimeType] ?? 'jpg';
    }
}
