<?php

namespace App\Models\traits;

trait CreateFolderTrait
{

    static function createFolder($name, $slug, $parentId = 0)
    {
        self::create([
            'name'      => $name,
            'slug'      => $slug,
            'parent_id' => $parentId
        ]);
    }
}
