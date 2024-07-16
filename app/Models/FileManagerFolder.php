<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FileManagerFolder extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'parent_id'];

    public function media(): HasMany
    {
        return $this->hasMany(FileManagerMedia::class, 'folder_id');
    }
}
