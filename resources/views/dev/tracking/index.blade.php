@php
	$keyword = (app('request')->get('keyword') !== null)?app('request')->get('keyword'):'';
    $keyword = (app('request')->get('mod') !== null)?app('request')->get('mod'):$keyword;
@endphp

@extends('dev.partials.layouts.extend.master')

@section('metadata')
	<meta name="keywords" content="MOVISTAR Internet Hogar"/>
	<meta name="description" content="Planes de internet hogar con FIBRA ÓPTICA, telefonía y tv con hasta el 20% de descuento por 12 meses ¡Pásate ya a Movistar!" />
	<title>Movistar Co | Planes de internet y telefonía para el hogar</title>
	<!-- inject-style src="../../css/purged/generica.css" -->
@stop

@section('content')
	@include('dev.partials.id_version.generica.main-banner')

	@if($keyword == "cobertura")
		@include('dev.partials.layouts.banners.banner-geosearch')
	@else
		@include('dev.partials.layouts.banners.banner-cobertura')
	@endif
	@include('dev.partials.id_version.generica.carousel.carousel-offers')
	@include('dev.partials.layouts.banners.banner-simple')
	@include('dev.partials.id_version.generica.list.list-services')
	@include('dev.partials.layouts.conditions.collapse')
@stop

