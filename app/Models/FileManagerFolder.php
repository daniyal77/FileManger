<?php

namespace App\Models;

use App\Models\traits\CreateFolderTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FileManagerFolder extends Model
{
    use CreateFolderTrait;

    protected $fillable = ['name', 'slug', 'parent_id'];

    public function media(): HasMany
    {
        return $this->hasMany(FileManagerMedia::class, 'folder_id');
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(FileManagerFolder::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(FileManagerFolder::class, 'parent_id');
    }
}
