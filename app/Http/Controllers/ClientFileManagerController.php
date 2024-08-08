<?php

namespace App\Http\Controllers;

use App\Models\FileManagerMedia;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
}
