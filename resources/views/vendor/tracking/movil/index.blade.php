@extends('partials.layouts.extend.master', [ 'main_c2c_class' => "no-carousel"])

@section('metadata')
	<meta name="keywords" content="MOVISTAR Móvil"/>
	<meta name="description" content="Movistar pospago Móvil, datos y llamadas ilimitadas. Ademas de 50% de descuento en el segundo y tercer mes." />
	@vite(['resources/sass/movil.scss', 'resources/js/generica.js'])
@stop

@section('title')
	Movistar Co | Planes pospago móvil con llamadas ilimitadas
@endsection

@section('content')
	@include('partials.id_version.generica.main-banner.sld-4')
	@include('partials.id_version.movil.carousel.carousel-offers')
	@include('partials.layouts.banners.banner-simple')
	@include('partials.id_version.movil.list.list-apps')
	@include('partials.id_version.movil.list.list-services')
	@include('partials.layouts.conditions.collapse')
@stop
