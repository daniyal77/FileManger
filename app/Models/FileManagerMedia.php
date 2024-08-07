<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileManagerMedia extends Model
{
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

}
