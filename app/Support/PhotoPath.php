<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class PhotoPath
{
    /**
     * Get relative path to photo.
     *
     * @param string $path
     * @return string
     */
    public static function relative($path)
    {
        return config('image.path.relative') . '/' . $path;
    }

    /**
     * Get absolute path to photo.
     *
     * @param string $path
     * @return string|null
     */
    public static function absolute($path)
    {
        if (!$path) {
            return null;
        }

        return Storage::url(self::relative($path));
    }
}
