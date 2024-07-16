<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class FileMangerController extends Controller
{
    public function index()
    {

        $directories = $this->showFolder();
        return view('welcome', compact('directories'));

    }

    public function showFolder()
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
