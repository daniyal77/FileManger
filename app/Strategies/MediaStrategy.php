<?php

namespace App\Strategies;

interface MediaStrategy
{
    public function upload($file,$folder_id,$type);
}
