@php
    $startFrom = $startFrom ?? 0;
@endphp

<div id="carouselBanner" class="splide" data-start-on="{{ $startFrom }}">
    <div class="splide__track">
        <div class="splide__list">
            <div class="splide__slide">
                @include('dev.partials.id_version.bogota-cundinamarca.main-banner.sld-1')
            </div>
            <div class="splide__slide">
                @include('dev.partials.id_version.bogota-cundinamarca.main-banner.sld-2')
            </div>
        </div>
    </div>

    <ul class="splide__pagination"></ul>
</div>
