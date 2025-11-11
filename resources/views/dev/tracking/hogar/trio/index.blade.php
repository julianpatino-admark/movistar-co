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
    <title>Claro | Hogar Triple play</title>
    <!-- inject-style src="../../css/purged/triple-play.css" -->
@stop

@section('content')
    @include('dev.partials.id_version.triple-play.main-banner')
    @include('dev.partials.id_version.triple-play.carousel.carousel-offers')
    @include('dev.partials.layouts.list.list-services')
    @include('dev.partials.layouts.banners.banner-simple')
    @include('dev.partials.layouts.conditions.collapse')
@stop
