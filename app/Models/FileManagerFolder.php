<?php

namespace App\Models;

use App\Models\traits\CreateFolderTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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
        if(static::whereSlug($slug = Str::slug($value))->exists())
        {
            if(static::whereSlug($slug)->get('id')->first()->id !== $this->id){
                $slug = $this->incrementSlug($slug);

                if(static::whereSlug($slug)->exists()){
                    return $this->setSlugAttribute($slug);
                }
            }
        }

        $this->attributes['slug'] = $slug;
    }

    /**
     * Increment slug
     *
     * @param   string $slug
     * @return  string
     **/
    public function incrementSlug($slug): string
    {
        // Get the slug of the created post earlier
        $max = static::whereSlug($slug)->latest('id')->value('slug');
        if (is_numeric($max[-1])) {
            return preg_replace_callback('/(\d+)$/', function ($matches) {
                return $matches[1] + 1;
            }, $max);
        }
        return "{$slug}-2";
    }
}
