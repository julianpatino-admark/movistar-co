<picture class="{{ $assetClass ?? '' }}">
    <source media="{{ $desktopMedia ?? '(min-width: 1200px)' }}" srcset="{{ Vite::asset('resources/img/hogar/redesign/'.$assetName.'-'.($desktopVariant ?? 'desktop').'.svg') }}">
    <source media="(max-width: 479px)" srcset="{{ Vite::asset('resources/img/hogar/redesign/'.$assetName.'-mobile.svg') }}">
    <img src="{{ Vite::asset('resources/img/hogar/redesign/'.$assetName.'-tablet.svg') }}" alt="{{ $assetAlt ?? '' }}">
</picture>
