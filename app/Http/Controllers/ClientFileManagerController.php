<?php

namespace App\Http\Controllers;

use App\Models\FileManagerMedia;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ClientFileManagerController extends Controller
{
    public function show($mediaId, $fileName): BinaryFileResponse
    {
        //todo check file is exsits
        $media=FileManagerMedia::findOrFail($mediaId);
        return response()->file($media->getMediaUrl());
    }
}
