<?php

namespace App\Http\Controllers;

use App\Models\FileManagerMedia;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ClientFileManagerController extends Controller
{
    public function show($mediaId, $fileName): BinaryFileResponse
    {
        $media = FileManagerMedia::findOrFail($mediaId);
        $path = $media->getMediaUrl();
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->file($path);
    }

    public function private($mediaId, $fileName): StreamedResponse
    {

        $media = FileManagerMedia::findOrFail($mediaId);
        $path = $media->getMediaUrl('private');
        if (Storage::disk('private')->exists($path)) {
            return Storage::disk('private')->download($path);
        }
        return abort(404);
    }
}
