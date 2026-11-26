@php
    use App\DTOs\OfferData;
    use App\DTOs\ServiceData;

    $responsiveService = static fn (string $icon, string $text) => new ServiceData(
        icon: 'resources/img/hogar/redesign/'.$icon.'-mobile.svg',
        text: $text,
        altText: '',
        sources: [
            ['media' => '(min-width: 1200px)', 'icon' => $icon === 'share' ? 'resources/img/movil/redesign/share-mobile.svg' : 'resources/img/hogar/redesign/'.$icon.'-desktop.svg'],
            ['media' => '(min-width: 480px)', 'icon' => 'resources/img/hogar/redesign/'.$icon.'-tablet.svg'],
        ],
    );

    // Published Figma prices: the campaign badge must not discount them again.
    $offers = collect([
        new OfferData(
            speed: 'Fibra 900', speedUnit: '', speedSubtitle: 'MEGAS + TV',
            price: 109155, isRecommended: true, layout: 'fiber-tv',
            legalText: 'Tarifa de referencia estratos 1 al 3, Servicio prestado por UNE o por COLTEL. Aplica para clientes nuevos.',
            customBadgeLabel: '<b>50% DTO x 1 mes.</b> Exclusivo Online',
            services: [
                new ServiceData(icon: 'resources/img/hogar/redesign/deco.svg', text: '<b>TV con 1 deco</b>incluido', altText: ''),
                new ServiceData(icon: 'resources/img/hogar/redesign/tv.svg', text: '<b>Movistar TV</b>App 74 canales', altText: ''),
            ],
        ),
        new OfferData(
            speed: 'Fibra 900', speedUnit: '', speedSubtitle: 'MEGAS simétricas',
            price: 84900, layout: 'fiber-only',
            legalText: 'Tarifa de referencia estratos 1 al 3, Servicio prestado por UNE o por COLTEL. Aplica para clientes nuevos.',
            customBadgeLabel: '<b>50% DTO x 1 mes.</b> Exclusivo Online',
            services: [
                $responsiveService('speed', '<b>Velocidad simétrica</b>'),
                $responsiveService('share', '<b>15 GIGAS</b>de tu plan para compartir'),
            ],
        ),
    ]);
@endphp

@include('partials.layouts.redesign.fiber-offers')
