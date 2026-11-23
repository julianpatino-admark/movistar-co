@php
    $heroPrefix = $heroPrefix ?? 'hogar';
    $heroHeading = $heroHeading ?? 'Internet Hogar: Fibra 900 megas simétricas';
    $heroService = $heroService ?? 'INTERNET HOGAR';
    $heroPromotions = $heroPromotions ?? [
        ['withTv' => false, 'price' => '84.900', 'label' => 'Fibra 900', 'c2c' => 'FIBRA 900 : 84.900'],
        ['withTv' => true, 'price' => '109.155', 'label' => 'Fibra 900 + TV', 'c2c' => 'FIBRA 900 + TV : 109.155'],
    ];
@endphp

<section class="hogar-banner" aria-labelledby="{{ $heroPrefix }}-title">
    <h1 id="{{ $heroPrefix }}-title" class="hogar-sr-only">{{ $heroHeading }}</h1>
    <div class="splide hogar-banner__carousel" id="{{ $heroPrefix }}-banners" data-fiber-banners aria-label="Promociones de {{ $heroService }}">
        <div class="splide__track">
            <div class="splide__list">
                @foreach($heroPromotions as $promotion)
                    @php($withTv = $promotion['withTv'])
                    <div class="splide__slide">
                        <article class="hogar-hero {{ $withTv ? 'hogar-hero--tv' : '' }}" aria-label="{{ $promotion['label'].' por $'.$promotion['price'] }}">
                            <div class="hogar-hero__photo" aria-hidden="true">
                                <img src="{{ Vite::asset('resources/img/hogar/redesign/'.($withTv ? 'hero-tv.webp' : 'hero-fibra.webp')) }}" alt="" width="{{ $withTv ? 1462 : 1600 }}" height="{{ $withTv ? 1076 : 1225 }}" fetchpriority="high">
                            </div>
                            <div class="hogar-hero__mask" aria-hidden="true">
                                @include('partials.id_version.hogar.redesign.asset', ['assetName' => 'hero-mask', 'desktopMedia' => '(min-width: 900px)'])
                            </div>
                            <div class="hogar-hero__content">
                                <h2 class="hogar-hero__title">
                                    @include('partials.id_version.hogar.redesign.asset', ['assetName' => 'fibra', 'assetAlt' => 'Fibra más.'])
                                </h2>
                                <p class="hogar-hero__tagline">Más velocidad para carga y descarga.</p>
                                <div class="hogar-hero__bundle" aria-label="{{ $withTv ? 'TV más 900 megas simétricas' : '900 megas simétricas' }}">
                                    @include('partials.id_version.hogar.redesign.asset', ['assetName' => 'bundle', 'assetClass' => 'hogar-hero__bundle-border'])
                                    <div class="hogar-hero__bundle-items" aria-hidden="true">
                                        @if($withTv)
                                            @include('partials.id_version.hogar.redesign.asset', ['assetName' => 'hero-tv', 'desktopVariant' => 'tablet'])
                                            @include('partials.id_version.hogar.redesign.asset', ['assetName' => 'plus', 'desktopVariant' => 'tablet'])
                                        @endif
                                        @include('partials.id_version.hogar.redesign.asset', ['assetName' => 'hero-wifi'])
                                        @include('partials.id_version.hogar.redesign.asset', ['assetName' => '900'])
                                        <span><strong>megas</strong><br>simétricas</span>
                                    </div>
                                </div>
                                <button type="button" class="hogar-hero__price" data-toggle="modal" data-target="#modal-c2c" data-c2c="{{ $promotion['c2c'] }}" data-tag-page="/modal/{{ $heroPrefix }}/banner-{{ $withTv ? 'tv' : 'fibra' }}/c2c" aria-label="Quiero {{ $promotion['label'].' por '.$promotion['price'].' pesos' }}">
                                    @include('partials.id_version.hogar.redesign.asset', ['assetName' => 'dollar'])
                                    <span>{{ $promotion['price'] }}</span>
                                </button>
                                <a class="hogar-hero__terms" href="#conditions">* Aplican términos y condiciones</a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
        <ul class="splide__pagination"></ul>
    </div>
    @include('partials.layouts.redesign.fiber-lead-form')
</section>
