@php
    $canonicalUrl = \App\Support\Seo::canonicalUrl(request()->path());
@endphp
<link rel="canonical" href="{{ $canonicalUrl }}">
<meta property="og:site_name" content="{{ config('seo.site_name') }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:title" content="@yield('title', config('seo.site_name'))">
<meta property="og:type" content="website">
@if ($canonicalUrl === \App\Support\Seo::url('/'))
<script type="application/ld+json">{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => config('seo.site_name'),
    'alternateName' => config('seo.alternate_name'),
    'url' => \App\Support\Seo::url('/'),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endif
