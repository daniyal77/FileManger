<?php

namespace App\Strategies;

use App\Strategies\Provider\Photo;

class UploadMedia
{
    public MediaStrategy $mediaStrategy;

    public function __construct($mineType)
    {
        if (str_starts_with($mineType, 'image/')) {
            $this->mediaStrategy = new Photo();
        }
    }
}
