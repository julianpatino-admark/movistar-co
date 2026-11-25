@php($offerPrefix = $offerPrefix ?? 'hogar')
<section class="carousel-wrapper movil-offers hogar-offers" aria-labelledby="{{ $offerPrefix }}-offers-title">
    <div class="splide container position-relative" id="{{ $offerPrefix }}-offers" data-fiber-offers data-phone-start="{{ $offersPhoneStart ?? 1 }}">
        <h2 class="title-section" id="{{ $offerPrefix }}-offers-title"><span>{{ $offersTitleStart ?? '¡Internet Fibra Óptica,' }}</span> <span>{{ $offersTitleEnd ?? 'la red fija más rápida!' }}</span></h2>
        <p class="subtitle-section">Encuentra el plan perfecto para ti.</p>
        <div class="splide__track">
            <div class="splide__list">
                @foreach($offers as $offer)
                    <div class="splide__slide">
                        <x-offer-card :offer="$offer" :offer-number="$loop->iteration"
                            :c2c-label="mb_strtoupper($offer->speed.' '.$offer->speedSubtitle).' : '.$offer->getFormattedDiscountPrice()"
                            :modal-title="$offer->speed.' '.$offer->speedSubtitle"
                            :cta-text="$offerCtaText ?? '¡LO QUIERO!'" :recommended-label="$offerRecommendedLabel ?? 'Plan recomendado'"
                            :tag-page="'/modal/'.$offerPrefix.'/offer-'.$loop->iteration.'/c2c'"
                            recommended-icon="resources/img/hogar/redesign/recommended.svg"
                            :recommended-icon-mobile="$offerRecommendedIconMobile ?? null" />
                    </div>
                @endforeach
            </div>
        </div>
        <ul class="splide__pagination"></ul>
        <p class="terminos-condiciones">{{ $offersLegal ?? 'Servicios sujetos a cobertura, intensidad de la señal, congestión de la red y equipo terminal, disponibilidad técnica y de equipos. Basado en datos de Ookla®️ Speedtest Intelligence®️, 1S 2026. Todos los derechos reservados. Aplican términos y condiciones. Más en tigo.com.co' }}</p>
    </div>
</section>
