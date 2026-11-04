@extends('dev.layouts.extend.master', [ 'main_c2c_class' => "no-carousel"])

@section('metadata')
	<meta name="keywords" content="MOVISTAR Móvil"/>
	<meta name="description" content="Movistar pospago Móvil, datos y llamadas ilimitadas. Ademas de 50% de descuento en el segundo y tercer mes." />
	<!-- inject-style src="../../css/purged/movil.css" -->
@stop

@section('title')
	Movistar Co | Planes pospago móvil con llamadas ilimitadas
@endsection

@section('content')
	@include('dev.id_version.generica.main-banner.sld-4')
	@include('dev.id_version.movil.carousel.carousel-offers')
	@include('dev.layouts.banners.banner-simple')
	@include('dev.id_version.movil.list.list-apps')
	@include('dev.id_version.movil.list.list-services')
	@include('dev.layouts.conditions.collapse')
@stop

@section('footer-scripts')
	@include('dev.layouts.extend.scripts')
@stop
