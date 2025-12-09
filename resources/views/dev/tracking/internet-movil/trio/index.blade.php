@php
	$keyword = (app('request')->get('keyword') !== null)?app('request')->get('keyword'):'';
    $keyword = (app('request')->get('mod') !== null)?app('request')->get('mod'):$keyword;
@endphp

@extends('dev.partials.layouts.extend.master', [ 'main_c2c_class' => "no-carousel"])

@section('metadata')
	<meta name="keywords" content="MOVISTAR Internet Hogar"/>
	<meta name="description" content="Planes de internet hogar con FIBRA ÓPTICA, telefonía y tv con hasta el 20% de descuento por 12 meses ¡Pásate ya a Movistar!" />
	<title>Movistar Co | Planes de internet y telefonía para el hogar</title>
	<!-- inject-style src="../../css/splide-core.min.css" -->
	<!-- inject-style src="../../css/internet-movil.css" -->
@stop

@section('content')
	@include('dev.partials.id_version.internet-movil.main-banner')
	@include('dev.partials.id_version.internet-movil.carousel.trio_fibra.carousel-offers')
	@include('dev.partials.layouts.banners.banner-simple')
	@include('dev.partials.id_version.generica.list.list-services')
	@include('dev.partials.layouts.conditions.collapse')
@stop

