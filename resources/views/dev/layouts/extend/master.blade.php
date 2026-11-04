@php
	$top = isset($top)?$top:true;
	$nav = isset($nav)?$nav:true;
	$header_phone = isset($header_phone)?$header_phone:true;
	$phone = ($header_phone === true)?$phone:"0";
	$main_c2c = isset($main_c2c)?$main_c2c:true;
	$main_c2c_class = $main_c2c_class ?? "";
    $modals = isset($modals)?$modals:true;
	$keyword = (app('request')->get('keyword') !== null)?app('request')->get('keyword'):'';
@endphp

<!doctype html>
<html lang="es">
<head>
	<!-- Google Tag Manager -->
	<script>
      (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
          new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-W2XDDSK');
	</script>
	<!-- End Google Tag Manager -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="facebook-domain-verification" content="mtpr61q04or29fm9e5nv3t48up9th9" />
	<meta id="provider" name="provider" content="{{$provider}}">
	<link rel="icon" href="/favicon.ico" sizes="any">
	<link rel="icon" href="/favicon.svg" type="image/svg+xml">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	
	<link rel="canonical" href="{{url()->current()}}/" />
	<title>@yield('title', 'Movistar')</title>
	@section('metadata')
	@show
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W2XDDSK" height="0" width="0" style="display:none;visibility:hidden" title="Google Tag Manager"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="main">
	@if($top === true)
		@include("dev.layouts.header.top-header")
		@include('dev.layouts.header.header')
		<nav class="navbar-collapse collapse" id="navbarMobileCollapse">
			@include("dev.layouts.navbar.nav-items")
		</nav>

	@endif
	@if($main_c2c === true)
		@include('dev.layouts.c2c.main', [ "c2c_class" => $main_c2c_class ])
	@endif

	@yield('content')

	@include('dev.layouts.footer.footer')
	@include('dev.layouts.cta.mobile-fixed')

	@include('dev.components.buttons.whatsapp')

    @if($modals === true)
        @section('modal')
            @include('dev.layouts.modal.c2c')
            @include('dev.layouts.modal.c2c-velocidades')
            @include('dev.layouts.modal.rgpd-config')
            @include('dev.layouts.modal.info-basica-privacidad')
            @include('dev.layouts.modal.privacy')
            @include('dev.layouts.modal.loaded-content')
            @include('dev.layouts.modal.legal')
            @include('dev.layouts.modal.response')
            @include('dev.layouts.modal.manual')
			@include('dev.layouts.modal.retencion')
        @show
    @endif

	<div id="current-phone" class="d-none">{{$phone_formatted}}</div>
	<div id="current-phone-link" class="d-none">{{$phone}}</div>
</div>
@section('footer-scripts')
	
@show
</body>
</html>