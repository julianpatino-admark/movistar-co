@extends('dev.partials.layouts.extend.master')

@section('metadata')
	<title>Landing Genérica</title>
	<!-- inject-style src="../../css/purged/movil.css" -->
@stop

@section('content')
	@include('dev.partials.id_version.movil.main-banner')
	@include('dev.partials.id_version.movil.carousel.carousel-offers')
	@include('dev.partials.layouts.banners.banner-simple')
	@include('dev.partials.id_version.movil.list.list-apps')
	@include('dev.partials.id_version.movil.list.list-services')
	@include('dev.partials.layouts.conditions.collapse')
@stop
