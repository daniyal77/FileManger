<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveFolder;
use App\Models\FileManagerFolder;
use Illuminate\Support\Facades\File;

class FileMangerFolderController extends Controller
{
    public function index()
    {
        $directories = FileManagerFolder::where('parent_id', 0)->get();
        $parent_id = 0;
        $media = null;
        return view('welcome', compact('directories', 'parent_id', 'media'));
    }

    public function store(SaveFolder $request)
    {
        //todo for create folder
        //replace space by - in slug
        //replace farsi slug to finglish
        FileManagerFolder::createFolder(name: $request->name, slug: $request->slug, parentId: $request->parent_id);
        return redirect()->back();
    }

    public function show($slug)
    {
        $parent = FileManagerFolder::where('slug', $slug)->with('media', 'children')->first();
        $parent_id = $parent->id;
        $directories = $parent->children;
        $media = $parent->media;
        return view('welcome', compact('media', 'parent', 'parent_id', 'directories'));
    }


    public function showFile()
    {
        $path = public_path('fi');
        $files = File::allFiles($path);
        foreach ($files as $file) {
            dd($file->getRelativePathname());
        }

        $directories = File::directories($path);
        $items = [];
        foreach ($directories as $folder) {
            $items[] = [
                'text'    => str_replace($path . "\\", '', $folder),
                'iconCls' => "",
            ];
        }

        return $items;
        return response()->json($items);
    }
}
