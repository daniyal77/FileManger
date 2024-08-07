<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class FileManagerMedia extends Model
{
    use SoftDeletes;

    protected $fillable = ['folder_id', 'slug', 'name', 'mime_type', 'size'];

    /**
     * Get the size in megabytes.
     *
     * @return float
     */
    public function getSizeInMbAttribute()
    {
        return $this->attributes['size'] / (1024 * 1024);
    }

    public function deleteFolder()
    {
        $folderPath = storage_path('app/public/uploads/' . $this->id);
        if (File::exists($folderPath)) {
            File::deleteDirectory($folderPath);
        }
    }

}
