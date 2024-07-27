<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveFolder;
use App\Http\Resources\ListFolders;
use App\Models\FileManagerFolder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileMangerFolderController extends ApiController
{
    public function index(): JsonResponse
    {
        $directories = FileManagerFolder::where('parent_id', null)->get();
        return $this->respond(
            [
                'directories' => ListFolders::make($directories)
            ]
        );
//        $parent_id = null;
//        $media = null;
//        return view('welcome', compact('directories', 'parent_id', 'media'));
    }

    public function store(SaveFolder $request): JsonResponse
    {
        //todo for create folder
        //replace space by - in slug
        //replace farsi slug to finglish
        FileManagerFolder::createFolder(name: $request->name, slug: $request->slug, parentId: $request->parent_id);
        return $this->successMessage("فولدر با موفقیت ساخته شد");
    }

    public function show($slug): JsonResponse
    {
        $parent = FileManagerFolder::where('slug', $slug)->with('media', 'children', 'parent')->first();
        $breadcrumbs = $parent->getBreadcrumb();
        return $this->respond(
            [
                'directory'   => ListFolders::make($parent),
                'breadcrumbs' => $breadcrumbs
            ]
        );
//
//        $parent_id = $parent->id;
//        $directories = $parent->children;
//        $media = $parent->media;
//        return view('welcome', compact('media', 'parent', 'parent_id', 'directories', 'breadcrumbs'));
    }

    public function rename(SaveFolder $request): JsonResponse
    {
        FileManagerFolder::updateFolder(name: $request->name, slug: $request->slug, id: $request->id);
        return $this->successMessage("فولدر با موفقیت ویرایش گردید");
    }

    public function delete(Request $request): JsonResponse
    {
        FileManagerFolder::findOrFail($request->id)->delete();
        return $this->successMessage("فولدر با موفقیت حذف گردید");
    }
}
