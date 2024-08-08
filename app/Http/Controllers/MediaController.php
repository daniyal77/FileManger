<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveMedia;
use App\Http\Resources\ShowInformationMedia;
use App\Models\FileManagerMedia;
use App\Strategies\UploadMedia;
use Illuminate\Http\JsonResponse;

class MediaController extends ApiController
{
    public function store(SaveMedia $request): JsonResponse
    {
        if (!is_array($request->file('media')))
            return $this->errorMessage("لطفا به صورت ارایه بفرستید");

        foreach ($request->file('media') as $file) {
            $mimeType = $file->getMimeType();
            $rules = [];
            if (str_starts_with($mimeType, 'video/')) {
                $rules['media'] = 'mimes:' . implode(',', config('filemanager.video.valid_mime')) . '|max:' . config('filemanager.video.max_size');
            } else {
                $rules['media'] = 'mimes:' . implode(',', config('filemanager.file.valid_mime')) . '|max:' . config('filemanager.file.max_size');
            }
            // Re-validate the file with specific rules

            $uploadMedia = new UploadMedia($mimeType);
            $uploadMedia->mediaStrategy->upload($file, $request->folder_id, request()->input('type', 'public'));
        }
        return $this->successMessage("با موفقیت اپلود شد");
    }

    public function update(): JsonResponse
    {
        $media = FileManagerMedia::findorFail(request()->id);
        $media->update(['name' => request()->name]);
        return $this->successMessage("با موفقیت بروز رسانی شد");

    }

    public function showLength($media_id): JsonResponse
    {
        $media = FileManagerMedia::findorFail($media_id);
        return $this->respond(['data' => $media]);
    }

    public function delete($media_id): JsonResponse
    {
        FileManagerMedia::findorFail($media_id)->delete();
        return $this->successMessage(" با موفقیت حذف گردید");
    }

    public function forceDelete($media_id): JsonResponse
    {
        $record = FileManagerMedia::withTrashed()->findorFail($media_id);
        if ($record) {
            $record->deleteFolder();
            $record->forceDelete();
        }
        return $this->successMessage(" با موفقیت حذف گردید");
    }

    public function filter($filter): JsonResponse
    {
        $filter = "image/" . $filter;
        $media = FileManagerMedia::where('mime_type', $filter)->get();
        return $this->respond([
            'data' => ShowInformationMedia::make($media)
        ]);
    }

    public function restore($media_id): JsonResponse
    {
        FileManagerMedia::withTrashed()->findorFail($media_id)->get();
        return $this->successMessage(" با موفقیت تغییر وضعیت داده شد");
    }
    public function trash(): JsonResponse
    {
        $media = FileManagerMedia::onlyTrashed()->get();
        return $this->respond([
            'data' => ShowInformationMedia::make($media)
        ]);
    }
}
