@extends('dev.partials.layouts.extend.master')

@section('metadata')
	<meta name="keywords" content="MOVISTAR Móvil"/>
	<meta name="description" content="Movistar pospago Móvil, datos y llamadas ilimitadas. Ademas de 50% de descuento en el segundo y tercer mes." />
	<title>Movistar Co | Planes pospago móvil con llamadas ilimitadas</title>
	<!-- inject-style src="../../css/splide-core.min.css" -->
	<!-- inject-style src="../../css/movil.css" -->
@stop

@section('content')
	@include('dev.partials.id_version.generica.main-banner', [ 'startFrom' => 3 ])
	@include('dev.partials.id_version.movil.carousel.carousel-offers')
	@include('dev.partials.layouts.banners.banner-simple')
	@include('dev.partials.id_version.movil.list.list-apps')
	@include('dev.partials.id_version.movil.list.list-services')
	@include('dev.partials.layouts.conditions.collapse')
@stop
