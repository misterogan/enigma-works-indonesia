<?php

namespace App\Support;

class Media
{
    /** URL gambar: mendukung file unggahan (storage) maupun path/URL biasa. */
    public static function url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }
        if (str_starts_with($path, 'http') || str_starts_with($path, '/')) {
            return $path;
        }

        return asset('storage/'.$path);
    }
}
