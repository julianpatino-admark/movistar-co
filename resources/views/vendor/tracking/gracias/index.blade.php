@extends('partials.layouts.extend.master',[
    'nav' => false,
    'header_phone' => false,
    'main_c2c' => false,
    'footer_form' => false,
    'main_cta_mobile' => false,
    'header_relative' => true
])

@section('metadata')
    @vite(['resources/sass/generica.scss'])

	<link rel="shortcut icon" type="image/svg" href="{{ asset('/img/common/favicon.svg') }}">
@stop

@section('title')
	Movistar Co | Gracias por tu registro
@endsection

@section('content')
	@include('partials.layouts.gracias.index')
@stop
