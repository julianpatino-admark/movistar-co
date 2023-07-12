@extends('dev.partials.layouts.extend.master', [
    'top' => false,
    'nav' => false,
    'header_phone' => false,
    'main_c2c' => false,
    'footer_form' => false,
    'main_cta_mobile' => false,
    'header_relative' => true
])

@section('metadata')
    <meta name="keywords" content="MOVISTAR Móvil"/>
    <meta name="description" content="Movistar pospago Móvil, datos y llamadas ilimitadas. Ademas de 50% de descuento en el segundo y tercer mes." />
    <title>Movistar Co | Planes pospago móvil con llamadas ilimitadas</title>
    <!-- inject-style src="../../css/purged/cobertura.css" -->
@stop

@section('content')
    @include('dev.partials.layouts.header.header-cobertura')
    @include("dev.partials.layouts.cobertura.index")
@stop
