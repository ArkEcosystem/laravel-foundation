<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Support;

final class FileUpload
{
    /**
     * Returns a file size limit in bytes based on the PHP upload_max_filesize
     * and post_max_size
     */
    public static function maxSize(): float
    {
        $maxSize = -1;

        // Start with post_max_size.
        $postMaxSize = static::parseSize(ini_get('post_max_size'));

        if ($postMaxSize > 0) {
            $maxSize = $postMaxSize;
        }

        // If upload_max_size is less, then reduce. Except if upload_max_size is
        // zero, which indicates no limit.
        $uploadMax = static::parseSize(ini_get('upload_max_filesize'));
        if ($uploadMax > 0 && $uploadMax < $maxSize) {
            $maxSize = $uploadMax;
        }

        return $maxSize;
    }

    public static function maxSizeFormatted(): string
    {
        return static::formatBytes(static::maxSize());
    }

    private static function parseSize(string $size): float
    {
        // Remove the non-unit characters from the size.
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size);
        // Remove the non-numeric characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size);

        if ($unit) {
            // Find the position of the unit in the ordered string which is the
            // power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round(intval($size));
        }
    }

    public static function formatBytes($bytes, $precision = 2): string
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . $units[$pow];
    }

}
