@php
	$keyword = (app('request')->get('keyword') !== null)?app('request')->get('keyword'):'';
    $keyword = (app('request')->get('mod') !== null)?app('request')->get('mod'):$keyword;
@endphp

@extends('partials.layouts.extend.master')

@section('metadata')
	<meta name="keywords" content="MOVISTAR Internet Hogar"/>
	<meta name="description" content="Planes de internet hogar con FIBRA ÓPTICA, telefonía y tv con hasta el 20% de descuento por 12 meses ¡Pásate ya a Movistar!" />
	<title>Movistar Co | Planes de internet y telefonía para el hogar</title>
	<!-- inject-style src="../../css/splide-core.min.css" -->
	<!-- inject-style src="../../css/internet-movil.css" -->
	@vite(['resources/sass/internet-movil.scss', 'resources/js/generica.js'])
@stop

@section('content')
	@include('partials.id_version.internet-movil.main-banner', [ 'startFrom' => 1 ])
	@include('partials.id_version.internet-movil.carousel.fibra.carousel-offers')
	@include('partials.layouts.banners.banner-simple')
	@include('partials.id_version.generica.list.list-services')
	@include('partials.layouts.conditions.collapse')
@stop
