<?php

namespace App\Strategies;

use App\Strategies\Provider\Photo;
use Intervention\Image\ImageManager;

class UploadMedia
{
    public MediaStrategy $mediaStrategy;

    public function __construct($mineType)
    {
        if (str_starts_with($mineType, 'image/')) {
            $manager = ImageManager::gd();

            $this->mediaStrategy = new Photo($manager);
        }
    }
}
