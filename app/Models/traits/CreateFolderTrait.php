<?php

namespace App\Models\traits;

trait CreateFolderTrait
{

    static function createFolder($name, $slug, $parentId = null)
    {
        self::create([
            'name'      => $name,
            'slug'      => $slug,
            'parent_id' => $parentId
        ]);
    }
    static function updateFolder($name, $slug, $id)
    {
        self::findOrFail($id)->update([
            'name'      => $name,
            'slug'      => $slug,
        ]);
    }
}
