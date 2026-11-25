<?php

namespace App\Support;

use Illuminate\Http\Request;

class Seo
{
    public static function url(string $path = '/'): string
    {
        return rtrim(config('seo.public_url'), '/').'/'.trim($path, '/');
    }

    public static function canonicalUrl(string $path): string
    {
        $path = '/'.trim($path, '/');

        return self::url(config('seo.aliases')[$path] ?? $path);
    }

    public static function publicHost(): string
    {
        return strtolower(parse_url(config('seo.public_url'), PHP_URL_HOST));
    }

    public static function isPublicHost(Request $request): bool
    {
        return strtolower($request->getHost()) === self::publicHost();
    }
}
