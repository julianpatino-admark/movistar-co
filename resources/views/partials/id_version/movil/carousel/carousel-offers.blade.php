@php
    use App\DTOs\OfferData;
    use App\DTOs\ServiceData;

    $responsiveService = static fn (string $icon, string $text) => new ServiceData(
        icon: 'resources/img/movil/redesign/'.$icon.'-mobile.svg', text: $text, altText: '',
        sources: [
            ['media' => '(min-width: 1200px)', 'icon' => 'resources/img/movil/redesign/'.$icon.'-mobile.svg'],
            ['media' => '(min-width: 480px)', 'icon' => 'resources/img/movil/redesign/'.$icon.'-tablet.svg'],
        ],
    );
    $social = new ServiceData(icon: 'resources/img/movil/redesign/social.png', text: '<b>Redes sociales</b>incluido en tu plan.', width: 37, height: 35, altText: '', sources: [['media' => '(min-width: 0px)', 'icon' => 'resources/img/movil/redesign/social.png']]);
    $share = $responsiveService('share', '<b>15 GIGAS</b>de tu plan para compartir.');
    // Use the displayed Figma prices without applying the campaign badge again.
    $offers = collect([
        new OfferData(
            speed: '60 GB', speedUnit: '', price: 53900,
            customBadgeLabel: '<b>20% dto x 3 meses.</b> Exclusivo online',
            layout: 'mobile pospago-60',
            services: [$social, $share, $responsiveService('calls', '<b>Llamadas ilimitadas</b>a todo operador nacional.')],
        ),
        new OfferData(
            speed: 'DATOS', speedUnit: '', speedSubtitle: 'ILIMITADOS', price: 69900,
            layout: 'mobile pospago-unlimited',
            services: [$social, $share, new ServiceData(icon: 'resources/img/movil/redesign/network.svg', text: '<b>RED 4.5G / 5G</b>mejor cobertura y velocidad.', altText: '', sources: [['media' => '(min-width: 0px)', 'icon' => 'resources/img/movil/redesign/network.svg']])],
        ),
    ]);
@endphp

<section class="carousel-wrapper movil-offers" aria-labelledby="movil-offers-title">
    <div class="splide container position-relative" id="movil-offers">
        <h2 class="title-section" id="movil-offers-title"><span>Conoce más de los</span> <span>planes Pospago</span></h2>
        <p class="subtitle-section">Encuentra el plan perfecto para ti.</p>
        <div class="splide__track">
            <div class="splide__list">
                @foreach($offers as $offer)
                    <div class="splide__slide">
                        <x-offer-card :offer="$offer" :offer-number="$loop->iteration" cta-text="¡LO QUIERO!"
                            :c2c-label="'MOVIL DE '.($loop->first ? '60 GB' : 'DATOS ILIMITADOS').' : '.$offer->getFormattedPrice()"
                            :modal-title="$loop->first ? '60 GB' : 'Datos ilimitados'" />
                    </div>
                @endforeach
            </div>
        </div>
        <ul class="splide__pagination"></ul>
    </div>
</section>
