@extends('partials.layouts.extend.master')

@section('body-class', 'movil-redesign hogar-redesign')

@section('metadata')
	<meta name="keywords" content="MOVISTAR Internet Hogar"/>
	<meta name="description" content="Encuentra en Ofertas Tienda planes Movistar de Fibra 900 desde $84.900 y Fibra 900 + TV por $109.155. Aplican condiciones y cobertura." />
	@vite(['resources/sass/hogar.scss', 'resources/js/hogar.js'])
@stop

@section('title', 'Ofertas Tienda | Internet Hogar Movistar con Fibra Óptica')

@section('page-header')
    @include('partials.id_version.movil.redesign.header', ['contentId' => 'hogar-content'])
@endsection

@section('content')
    <main id="hogar-content">
        @include('partials.layouts.redesign.fiber-hero')
        <nav class="movil-services" aria-label="Elige tu servicio">
            @include('partials.layouts.navbar.nav-items', ['navigationIcons' => 'services'])
        </nav>
        @include('partials.id_version.hogar.redesign.offers')
        @include('partials.id_version.movil.redesign.advisor', [
            'advisorC2c' => 'ASESORIA INTERNET HOGAR',
            'advisorTag' => '/modal/internet-hogar/asesoria/c2c',
        ])
    </main>
@endsection

@section('page-footer')
	@include('partials.layouts.conditions.collapse')
    @include('partials.id_version.movil.redesign.footer')
@stop
