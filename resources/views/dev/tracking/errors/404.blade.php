@extends('dev.partials.layouts.extend.master',[
    'nav' => false,
    'header_phone' => false,
    'main_c2c' => false
])

@section('metadata')
	<title>{{config('app.name')}} - Error 404. Página no encontrada</title>
	<!-- inject-style src="../../css/purged/generica.css" -->
@stop

@section('content')
	@include('dev.partials.layouts.errors.404')
@stop




