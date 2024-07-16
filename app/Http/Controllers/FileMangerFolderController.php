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
        return view('welcome', compact('directories'));

    }

    public function store(SaveFolder $request)
    {
        //todo for create folder
        //add event for save
        //replace space by - in slug
        //replace farsi slug to finglish

        FileManagerFolder::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);
        return redirect()->back();
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
