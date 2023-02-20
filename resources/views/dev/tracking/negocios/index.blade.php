@extends('dev.partials.layouts.extend.master')

@section('metadata')
	<meta name="keywords" content="MOVISTAR Pymes"/>
	<meta name="description" content="Internet fibra óptica con velocidad simétrica para tu negocio con 20% de descuento por 12 meses y web Movistar." />
	<title>Movistar Co | Planes de Internet fibra óptica para tu negocio</title>
	<!-- inject-style src="../../css/purged/negocios.css" -->
@stop

@section('content')
	@include('dev.partials.id_version.negocios.main-banner')
	@include('dev.partials.id_version.negocios.carousel.carousel-offers')
	@include('dev.partials.layouts.banners.banner-simple')
	@include('dev.partials.id_version.negocios.list.list-apps')
	@include('dev.partials.id_version.negocios.list.list-services')
	@include('dev.partials.layouts.conditions.collapse')
@stop
