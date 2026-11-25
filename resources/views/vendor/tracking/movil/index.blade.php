@extends('partials.layouts.extend.master')

@section('body-class', 'movil-redesign movil-pospago')

@section('metadata')
	<meta name="keywords" content="MOVISTAR Móvil"/>
	<meta name="description" content="Conoce en Ofertas Tienda los planes Movistar Pospago: 60 GB por $53.900 o datos ilimitados por $69.900. Consulta beneficios y condiciones." />
	@vite(['resources/sass/movil.scss', 'resources/js/movil.js'])
@stop

@section('title', 'Ofertas Tienda | Planes Movistar Pospago')

@section('page-header')
	@include('partials.id_version.movil.redesign.header')
@endsection

@section('content')
	<main id="movil-content">
		@include('partials.id_version.movil.redesign.hero')
		<nav class="movil-services" aria-label="Tipo de servicio">
			@include('partials.layouts.navbar.nav-items', ['navigationIcons' => 'services'])
		</nav>
		@include('partials.id_version.movil.carousel.carousel-offers')
		@include('partials.id_version.movil.redesign.advisor', ['mobileInfo' => true])
	</main>
@stop

@section('page-footer')
	@include('partials.layouts.conditions.collapse')
	@include('partials.id_version.movil.redesign.footer')
@stop
