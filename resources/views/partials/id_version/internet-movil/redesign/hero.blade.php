@php
    $heroPrefix = 'internet-movil';
    $heroSubmitText = '¡Llámame!';
    $promotions = [
        ['tv' => true, 'price' => '149.900', 'label' => 'Fibra 900 + TV + Pospago ilimitado'],
        ['tv' => false, 'price' => '119.900', 'label' => 'Fibra 900 + Pospago ilimitado'],
    ];
@endphp

<section class="hogar-banner total-banner" aria-labelledby="internet-movil-title">
    <h1 id="internet-movil-title" class="hogar-sr-only">Internet Hogar + Móvil: Full Tigo con Fibra 900 megas simétricas</h1>
    <div class="splide hogar-banner__carousel" id="internet-movil-banners" data-fiber-banners aria-label="Promociones de Internet Hogar + Móvil">
        <div class="splide__track">
            <div class="splide__list">
                @foreach($promotions as $promotion)
                    <div class="splide__slide">
                        <article class="total-hero {{ $promotion['tv'] ? 'total-hero--tv' : 'total-hero--stream' }}" aria-label="{{ $promotion['label'].' por $'.$promotion['price'] }}">
                            <div class="total-hero__stage">
                                <div class="total-hero__photo" aria-hidden="true">
                                    <img src="{{ Vite::asset('resources/img/internet-movil/redesign/banner-'.($promotion['tv'] ? 'laliga' : 'marshals').'.png') }}" alt="" fetchpriority="{{ $promotion['tv'] ? 'auto' : 'high' }}">
                                </div>
                                <div class="total-hero__mask" aria-hidden="true">
                                    @if($promotion['tv'])
                                        <img class="total-hero__mask-desktop" src="{{ Vite::asset('resources/img/internet-movil/redesign/banner-mask-desktop.svg') }}" alt="">
                                        <picture class="total-hero__mask-blue">
                                            <source media="(max-width: 479px)" srcset="{{ Vite::asset('resources/img/internet-movil/redesign/banner-mask-tv-blue-mobile.svg') }}">
                                            <img src="{{ Vite::asset('resources/img/internet-movil/redesign/banner-mask-tv-blue-tablet.svg') }}" alt="">
                                        </picture>
                                        <picture class="total-hero__mask-yellow">
                                            <source media="(max-width: 479px)" srcset="{{ Vite::asset('resources/img/internet-movil/redesign/banner-mask-tv-yellow-mobile.svg') }}">
                                            <img src="{{ Vite::asset('resources/img/internet-movil/redesign/banner-mask-tv-yellow-tablet.svg') }}" alt="">
                                        </picture>
                                    @else
                                        @include('partials.id_version.internet-movil.redesign.asset', ['bannerAsset' => 'mask'])
                                    @endif
                                </div>
                                <div class="total-hero__content">
                                    <div class="total-hero__heading">
                                        @include('partials.id_version.internet-movil.redesign.asset', ['bannerAsset' => 'apps', 'bannerAssetClass' => 'total-hero__apps'])
                                        <h2>Full Tigo</h2>
                                    </div>
                                    <p class="total-hero__fiber"><strong>Ahora con Fibra</strong><em>900 megas simétricas</em></p>
                                    <div class="total-hero__benefits">
                                        <p class="total-hero__mobile"><span>Pospago</span><strong>ilimitado</strong></p>
                                        <span class="total-hero__divider" aria-hidden="true">@include('partials.id_version.internet-movil.redesign.asset', ['bannerAsset' => 'divider'.($promotion['tv'] ? '' : '-stream')])</span>
                                        <div class="total-hero__streaming">
                                            <div class="total-hero__logos">
                                                @if($promotion['tv'])
                                                    @include('partials.id_version.internet-movil.redesign.asset', ['bannerAsset' => 'hbo', 'bannerAssetAlt' => 'HBO'])
                                                @endif
                                                @include('partials.id_version.internet-movil.redesign.asset', ['bannerAsset' => 'paramount'.($promotion['tv'] ? '' : '-stream'), 'bannerAssetAlt' => 'Paramount+'])
                                            </div>
                                            <p>por 12 meses</p>
                                        </div>
                                        @if($promotion['tv'])
                                            <span class="total-hero__divider" aria-hidden="true">@include('partials.id_version.internet-movil.redesign.asset', ['bannerAsset' => 'divider'])</span>
                                            <p class="total-hero__tv"><strong>TV</strong><span>avanzada</span></p>
                                        @endif
                                    </div>
                                    <button class="total-hero__price" type="button" data-toggle="modal" data-target="#modal-c2c" data-c2c="{{ mb_strtoupper($promotion['label']).' : '.$promotion['price'] }}" data-tag-page="/modal/internet-movil/banner-{{ $promotion['tv'] ? 'tv' : 'fibra' }}/c2c" aria-label="Quiero {{ $promotion['label'].' por '.$promotion['price'].' pesos' }}">
                                        @include('partials.id_version.internet-movil.redesign.asset', ['bannerAsset' => 'dollar'.($promotion['tv'] ? '' : '-stream')])
                                        <span>{{ $promotion['price'] }}</span>
                                    </button>
                                    <a class="total-hero__terms" href="#conditions">* Aplican términos y condiciones</a>
                                </div>
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
