@extends('partials.layouts.extend.status', ['statusContentId' => 'thankyou-content'])

@section('body-class', 'movil-redesign thankyou-page')

@section('metadata')
    <meta name="robots" content="noindex, follow">
    @vite(['resources/sass/thankyou.scss', 'resources/js/landing.js'])
@stop

@section('title')
	Movistar Co | Gracias por tu registro
@endsection

@section('content')
	@include('partials.layouts.gracias.index')
@stop
