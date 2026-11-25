@extends('partials.layouts.extend.status', ['statusContentId' => 'not-found-content'])

@section('body-class', 'movil-redesign not-found-page')

@section('title', 'Movistar Co | Error 404. Página no encontrada')

@section('metadata')
    <meta name="robots" content="noindex, follow">
    @vite(['resources/sass/not-found.scss', 'resources/js/landing.js'])
@stop

@section('content')
	@include('partials.layouts.errors.404')
@stop
