<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

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

    public function getMediaUrl($type = 'public')
    {
        if ($type == 'public')
            return 'storage/uploads/' . $this->id . "/" . $this->id . "." . $this->getExtensionFromMimeType($this->mime_type);
        else
            return 'uploads/' . $this->id . "/" . $this->id . "." . $this->getExtensionFromMimeType($this->mime_type);
    }

    public function getMediaPrivateUrl()
    {
        return URL::signedRoute('optimizeImageSigned',
            [
                'id'        => $this->id,
                'file_name' =>  $this->name,
            ]);

    }

    public function getExtensionFromMimeType($mimeType): string
    {
        $mimeMap = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif',
        ];

        return $mimeMap[$mimeType] ?? 'jpg';
    }
}
