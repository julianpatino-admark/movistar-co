<?php

namespace App\Http\Middleware;

use App\Support\Seo;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchVisibility
{
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->method(), ['GET', 'HEAD'], true)
            && strtolower($request->getHost()) === 'www.'.Seo::publicHost()) {
            return redirect()->away(rtrim(config('seo.public_url'), '/').$request->getRequestUri(), 301);
        }

        $response = $next($request);

        // Crawlers must be able to fetch preview pages to see this directive.
        if (!Seo::isPublicHost($request) && !$response->headers->has('X-Robots-Tag')) {
            $response->headers->set('X-Robots-Tag', 'noindex, follow');
        }

        return $response;
    }
}
