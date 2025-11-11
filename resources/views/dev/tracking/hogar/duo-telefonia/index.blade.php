@extends('dev.partials.layouts.extend.master', [
    "links" => array(
        [
            "name" => "1 Play",
            "path" => "hogar"
        ],
        [
            "name" => "2 Play",
            "path" => "hogar/duo-telefonia"
        ],
        [
            "name" => "3 Play",
            "path" => "hogar/trio"
        ],
    )
])

@section('metadata')
    <title>Claro | Hogar Duo Play - Telefonia</title>
    <!-- inject-style src="../../css/purged/duo-play.css" -->
@stop

@section('content')
    @include('dev.partials.id_version.duo-play.main-banner')
    @include('dev.partials.id_version.duo-play.carousel.carousel-offers-telefonia')
    @include('dev.partials.layouts.list.list-services')
    @include('dev.partials.layouts.banners.banner-simple')
    @include('dev.partials.layouts.conditions.collapse')
@stop
