@extends('dev.partials.layouts.extend.master', [
    "links" => array(
        [
            "name" => "Max Ilimitado",
            "path" => "movil"
        ],
        [
            "name" => "Max",
            "path" => "movil/max"
        ]
    )
])

@section('metadata')
    <title>Claro | Movil Max</title>
    <!-- inject-style src="../../css/purged/movil.css" -->

    <meta name="description" content="Encuentra planes móvil postpago ilimitados y disfruta de los todos beneficios que Claro que tiene." />
	<meta name="keywords" content="Claro, Claro Perú, Claro Móvil, Claro Planes Móvil, Claro Máx Ilimitado, Claro Planes ilimitados, Claro Planes, Claro Postpago, Claro Postpago ilimitados, Claro Móvil Postpago, Claro Portabilidad,  Claro Portabilidad Móvil, Portabilidad Móvil, Planes Móvil, Planes Móvil ilimitados, Planes Postpago ilimitados">
@stop

@section('content')
    @include('dev.partials.id_version.movil.main-banner')
    @include('dev.partials.id_version.movil.carousel.carousel-offers-max')
    @include('dev.partials.layouts.banners.banner-moviles')
    @include('dev.partials.layouts.list.list-services_mobile')
    @include('dev.partials.layouts.banners.banner-simple')
    @include('dev.partials.layouts.conditions.collapse')
@stop
