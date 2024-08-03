<?php

namespace App\Models;

use App\Models\traits\CreateFolderTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FileManagerFolder extends Model
{
    use CreateFolderTrait, SoftDeletes;

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

    public function getBreadcrumb(): Collection
    {
        $breadcrumb = collect();
        $folder = $this;

        while ($folder) {
            $breadcrumb->prepend($folder);
            $folder = $folder->parent;
        }

        return $breadcrumb;
    }


    /**
     * @param $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        $slug = Str::slug($value);
        // Check if the slug already exists and if it belongs to another record
        $existingSlug = static::whereSlug($slug)->first();
        if ($existingSlug) {
            // If the existing slug is not the same as the current record's slug, increment it
            if ($existingSlug->id !== $this->id) {
                $slug = $this->incrementSlug($slug);
            }
        }
        $this->attributes['slug'] = $slug;
    }

    /**
     * Increment slug
     *
     * @param string $slug
     * @return  string
     **/
    public function incrementSlug($slug): string
    {
        $originalSlug = $slug;
        $count = 1;

        while (static::whereSlug($slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    protected static function booted()
    {
        static::deleting(function ($folder) {
            $folder->children()->each(function ($child) {
                $child->delete();
            });
            $folder->media()->each(function ($media) {
                $media->delete();
            });
        });

        static::restoring(function ($folder) {
            $folder->children()->withTrashed()->each(function ($child) {
                $child->restore();
            });
            //todo refactor
//            $folder->media()->withTrashed()->each(function ($media) {
//                $media->restore();
//            });
        });
    }
}
