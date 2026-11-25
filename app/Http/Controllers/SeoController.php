<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function robots(): Response
    {
        return response("User-agent: *\nDisallow:\n\nSitemap: ".Seo::url('/sitemap.xml')."\n", 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }

    public function sitemap(): Response
    {
        return response()->view('seo.sitemap', [
            'urls' => array_map([Seo::class, 'url'], config('seo.sitemap_paths')),
        ], 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
