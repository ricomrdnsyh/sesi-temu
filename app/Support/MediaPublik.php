<?php

namespace App\Support;

use Illuminate\Support\Str;

class MediaPublik
{
    public static function url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, 'blob:')) {
            return $path;
        }

        if (Str::startsWith($path, ['http://', 'https://', 'aset-demo/', 'aset-tema/', 'storage/'])) {
            return asset($path);
        }

        return asset('storage/'.ltrim($path, '/'));
    }
}
