<picture class="{{ $bannerAssetClass ?? '' }}">
    <source media="(min-width: 900px)" srcset="{{ Vite::asset('resources/img/internet-movil/redesign/banner-'.str_replace('-stream', '', $bannerAsset).'-desktop.svg') }}">
    <source media="(max-width: 479px)" srcset="{{ Vite::asset('resources/img/internet-movil/redesign/banner-'.$bannerAsset.'-mobile.svg') }}">
    <img src="{{ Vite::asset('resources/img/internet-movil/redesign/banner-'.$bannerAsset.'-tablet.svg') }}" alt="{{ $bannerAssetAlt ?? '' }}">
</picture>
