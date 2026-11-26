@php
    use App\DTOs\OfferData;
    use App\DTOs\ServiceData;

    $mtIcon = static function (string $name, string $text, string $alt = '') {
        $mobile = match ($name) {
            'speed', 'share' => 'resources/img/hogar/redesign/'.$name.'-mobile.svg',
            'paramount-only' => 'resources/img/internet-movil/redesign/card-paramount-mobile.svg',
            default => 'resources/img/internet-movil/redesign/card-'.$name.'-mobile.svg',
        };
        $tablet = in_array($name, ['speed', 'share', 'paramount-only'])
            ? 'resources/img/internet-movil/redesign/card-'.$name.'-tablet.svg' : $mobile;
        return new ServiceData(icon: $mobile, text: $text, altText: $alt, sources: [
            ['media' => '(min-width: 1200px)', 'icon' => 'resources/img/internet-movil/redesign/card-'.($name === 'paramount-only' ? 'paramount' : $name).'-desktop.svg'],
            ['media' => '(min-width: 480px)', 'icon' => $tablet],
        ]);
    };
    // The prices are already the published campaign prices.
    $offerRecommendedIconMobile = 'resources/img/internet-movil/redesign/card-recommended-mobile.svg';
    $offersPhoneStart = 0;
    $offers = collect([
        new OfferData(
            speed: 'Fibra 900 MEGAS', speedUnit: '', speedSubtitle: '+ TV + Pospago ilimitado',
            price: 149900, isRecommended: true, layout: 'total-tv',
            legalText: 'Tarifa de referencia estratos 1 al 6, Servicio prestado por UNE, Colombia Móvil o COLTEL. Aplica para clientes nuevos.',
            customBadgeLabel: '<b>20% DTO x 12 mes.</b> Exclusivo Online',
            services: [$mtIcon('deco', '<b>TV con 1 deco</b>incluido'), $mtIcon('tv', '<b>Movistar TV</b>App 74 canales')],
            packages: [$mtIcon('paramount', 'x 12 meses', 'Paramount+'), $mtIcon('hbo', 'x 2 meses', 'HBO')],
        ),
        new OfferData(
            speed: 'Fibra 900 MEGAS', speedUnit: '', speedSubtitle: '+ Pospago ilimitado',
            price: 119900, layout: 'total-fiber',
            legalText: 'Tarifa de referencia estratos 1 al 6, Servicio prestado por UNE, Colombia Móvil o COLTEL. Aplica para clientes nuevos.',
            customBadgeLabel: '<b>20% DTO x 12 mes.</b> Exclusivo Online',
            services: [$mtIcon('speed', '<b>Velocidad simétrica</b>'), $mtIcon('share', '<b>15 GIGAS</b>de tu plan para compartir')],
            packages: [$mtIcon('paramount-only', 'x 12 meses.', 'Paramount+')],
        ),
    ]);
@endphp

@include('partials.layouts.redesign.fiber-offers')
