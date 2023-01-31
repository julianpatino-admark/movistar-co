@extends('dev.partials.layouts.extend.master')

@section('metadata')
	<title>Landing Genérica</title>
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
