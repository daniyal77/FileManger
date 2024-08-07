<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveMedia;
use App\Models\FileManagerMedia;
use App\Strategies\UploadMedia;

class MediaController extends ApiController
{
    public function store(SaveMedia $request)
    {
        $file = $request->file('media');
        $mimeType = $file->getMimeType();
        $rules = [];

        if (str_starts_with($mimeType, 'video/')) {
            $rules['media'] = 'mimes:' . implode(',', config('filemanager.video.valid_mime')) . '|max:' . config('filemanager.video.max_size');
        } else {
            $rules['media'] = 'mimes:' . implode(',', config('filemanager.file.valid_mime')) . '|max:' . config('filemanager.file.max_size');
        }
        // Re-validate the file with specific rules

        $uploadMedia = new UploadMedia($mimeType);
        $uploadMedia->mediaStrategy->upload($request);
    }

    public function update()
    {
        $media = FileManagerMedia::findorFail(request()->id);
        $media->update([
            'name' => request()->name
        ]);
    }

    public function showLength($media_id)
    {
        $media = FileManagerMedia::findorFail($media_id);
        return $this->respond([
            'data' => $media
        ]);
    }
}
