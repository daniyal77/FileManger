<?php

namespace App\Http\Controllers;

class DiskSpaceController extends ApiController
{
    public function index()
    {

        // گرفتن فضای کل دیسک در بایت
        $totalSpace = disk_total_space("/");

        // گرفتن فضای آزاد دیسک در بایت
        $freeSpace = disk_free_space("/");

        // محاسبه فضای استفاده شده
        $usedSpace = $totalSpace - $freeSpace;

        // تبدیل به واحد مناسب برای نمایش بهتر
        $totalSpaceFormatted = $this->formatBytes($totalSpace);
        $freeSpaceFormatted = $this->formatBytes($freeSpace);
        $usedSpaceFormatted = $this->formatBytes($usedSpace);

        return $this->respond([
            'total_space' => $totalSpaceFormatted,
            'free_space'  => $freeSpaceFormatted,
            'used_space'  => $usedSpaceFormatted,
        ]);
    }

    private function formatBytes($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}
