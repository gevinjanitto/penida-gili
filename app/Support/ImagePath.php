<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

/**
 * Catalogue images live in two places: the design assets shipped under
 * public/images/<folder>, and admin uploads on the public disk. Both are
 * stored as bare paths; this resolves either to a URL.
 */
final class ImagePath
{
    public static function url(?string $path, string $folder): string
    {
        if (blank($path)) {
            return asset('images/placeholder.svg');
        }

        if (str_starts_with($path, 'uploads/')) {
            return Storage::disk('public')->url($path);
        }

        return asset('images/'.$folder.'/'.ltrim($path, '/'));
    }

    /** Whether the file behind a stored path is actually there (shipped asset or upload). */
    public static function exists(?string $path, string $folder): bool
    {
        if (blank($path)) {
            return false;
        }

        if (str_starts_with($path, 'uploads/')) {
            return Storage::disk('public')->exists($path);
        }

        return is_file(public_path('images/'.$folder.'/'.ltrim($path, '/')));
    }
}
