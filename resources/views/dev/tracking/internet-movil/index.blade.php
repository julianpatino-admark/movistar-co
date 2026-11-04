@php
	$keyword = (app('request')->get('keyword') !== null)?app('request')->get('keyword'):'';
    $keyword = (app('request')->get('mod') !== null)?app('request')->get('mod'):$keyword;
@endphp

@extends('dev.layouts.extend.master', [ 'main_c2c_class' => "no-carousel"])

@section('metadata')
	<meta name="keywords" content="MOVISTAR Internet Hogar"/>
	<meta name="description" content="Planes de internet hogar con FIBRA ÓPTICA, telefonía y tv con hasta el 20% de descuento por 12 meses ¡Pásate ya a Movistar!" />
	<!-- inject-style src="../../css/purged/internet-movil.css" -->
@stop

@section('title')
	Movistar Co | Planes de internet y telefonía para el hogar
@endsection

@section('content')
	@include('dev.id_version.internet-movil.main-banner', [ 'startFrom' => 1 ])
	@include('dev.id_version.internet-movil.carousel.carousel-offers')
	@include('dev.layouts.banners.banner-simple')
	@include('dev.id_version.generica.list.list-services')
	@include('dev.layouts.conditions.collapse')
@stop

@section('footer-scripts')
	@include('dev.layouts.extend.scripts')
@stop
