<?php
return [

    'file'  => [
        'max_size'   => 50000, // size in KB
        'valid_mime' => [
            'image/jpeg',
            'image/pjpeg',
            'image/png',
            'image/gif',
            'application/pdf',
            'text/plain',
        ],
    ],
    'image' => [
        'max_size'       => 50000, // size in KB
        'valid_mime'     => [
            'image/jpeg',
            'image/pjpeg',
            'image/png',
            'image/gif',
        ],
        'thumbnail'      => true,
        'create_webp'    => true,
        'thumbnail_size' => [
            'small'  => '250*250',
            'medium' => '250*250',
        ]
    ],
    'video' => [
        'max_size'   => 50000, // size in KB
        'valid_mime' => [
            'image/jpeg',
            'image/pjpeg',
            'image/png',
            'image/gif',
        ],
    ],
];
