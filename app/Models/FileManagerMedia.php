<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileManagerMedia extends Model
{
    protected $fillable = ['folder_id', 'slug', 'name', 'mime_type', 'size'];
}
