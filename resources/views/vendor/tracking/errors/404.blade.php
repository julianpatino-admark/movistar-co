@extends('partials.layouts.extend.master',[
    'nav' => false,
    'header_phone' => true,
    'main_c2c' => false
])

@section('metadata')
	<title>{{config('app.name')}} - Error 404. Página no encontrada</title>
	<!-- inject-style src="../../css/purged/generica.css" -->
    @vite(['resources/sass/internet-movil.scss'])
@stop

@section('content')
	@include('partials.layouts.errors.404')
@stop
