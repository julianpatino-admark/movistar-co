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
    <title>Claro | Hogar Play Duo - TV</title>
    <!-- inject-style src="../../css/duo-play-tv.css" -->
@stop

@section('content')
    @include('dev.partials.id_version.duo-play.main-banner-tv')
    @include('dev.partials.id_version.duo-play.carousel.carousel-offers-television')
    @include('dev.partials.layouts.list.list-services')
    @include('dev.partials.layouts.banners.banner-simple')
    @include('dev.partials.layouts.conditions.collapse')
@stop
