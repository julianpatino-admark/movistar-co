@extends('partials.layouts.extend.master',[
    'nav' => false,
    'header_phone' => false,
    'main_c2c' => false,
    'footer_form' => false,
    'main_cta_mobile' => false,
    'header_relative' => true
])

@section('metadata')
	<title>Movistar Co | Gracias por tu registro</title>
	<!-- inject-style src="../../css/purged/generica.css" -->
    @vite(['resources/sass/generica.scss'])

	<link rel="shortcut icon" type="image/svg" href="{{ asset('/img/common/favicon.svg') }}">
@stop

@section('content')
	@include('partials.layouts.gracias.index')
@stop
