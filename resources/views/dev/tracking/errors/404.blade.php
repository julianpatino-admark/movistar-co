@extends('dev.layouts.extend.master',[
    'nav' => false,
    'header_phone' => true,
    'main_c2c' => false
])

@section('title', config('app.name') . ' - Error 404. Página no encontrada')

@section('metadata')
	<!-- inject-style src="../../css/purged/generica.css" -->
    <!-- inject-style src="../../css/purged/internet-movil.css" -->
@stop

@section('content')
	@include('dev.layouts.errors.404')
@stop
