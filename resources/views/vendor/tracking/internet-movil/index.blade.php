@extends('partials.layouts.extend.master')

@section('body-class', 'movil-redesign hogar-redesign internet-movil-redesign')

@section('metadata')
    <meta name="keywords" content="MOVISTAR Internet Hogar + Móvil"/>
    <meta name="description" content="En Ofertas Tienda conoce planes Movistar de Fibra 900 con Pospago ilimitado desde $119.900 y 20% de descuento por 12 meses. Aplican condiciones y cobertura."/>
    @vite(['resources/sass/internet-movil.scss', 'resources/js/internet-movil.js'])
@endsection

@section('title', 'Ofertas Tienda | Planes Movistar Internet Hogar + Móvil')

@section('page-header')
    @include('partials.id_version.movil.redesign.header', ['contentId' => 'internet-movil-content'])
@endsection

@section('content')
    <main id="internet-movil-content">
        @include('partials.id_version.internet-movil.redesign.hero')
        <nav class="movil-services" aria-label="Elige tu servicio">
            @include('partials.layouts.navbar.nav-items', ['navigationIcons' => 'services'])
        </nav>
        @include('partials.id_version.internet-movil.redesign.offers', [
            'offerPrefix' => 'internet-movil',
            'offerCtaText' => '¡LO QUIERO!',
            'offerRecommendedLabel' => 'Plan recomendado',
            'offersLegal' => 'Servicios sujetos a cobertura, intensidad de la señal, congestión de la red y equipo terminal, disponibilidad técnica y de equipos. Basado en datos de Ookla®️ Speedtest Intelligence®️, 1S 2026. Todos los derechos reservados. Aplican términos y condiciones. Más en tigo.com.co',
        ])
        @include('partials.id_version.movil.redesign.advisor', [
            'advisorC2c' => 'ASESORIA INTERNET FIBRA',
            'advisorTag' => '/modal/internet-movil/asesoria/c2c',
            'homeInformationC2c' => 'INFORMACION INTERNET FIBRA',
            'homeInformationTag' => '/modal/internet-movil/informacion/c2c',
        ])
    </main>
@endsection

@section('page-footer')
    @include('partials.layouts.conditions.collapse')
    @include('partials.id_version.movil.redesign.footer')
@endsection
