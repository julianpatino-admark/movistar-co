@php
	$top = isset($top)?$top:true;
	$nav = isset($nav)?$nav:true;
	$header_phone = isset($header_phone)?$header_phone:true;
	$phone = ($header_phone === true)?$phone:"0";
	$main_c2c = isset($main_c2c)?$main_c2c:true;
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
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

	@section('metadata')
	@show
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W2XDDSK" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="main">
	@if($top === true)
		@include("dev.partials.layouts.header.top-header")
		@include('dev.partials.layouts.header.header')
		@include('dev.partials.layouts.navbar.mobile-nav')
	@endif
	@if($main_c2c === true)
		@include('dev.partials.layouts.c2c.main')
	@endif

	@yield('content')

	@include('dev.partials.layouts.footer.footer')
	@include('dev.partials.layouts.cta.mobile-fixed')


	@if (str_contains($keyword, 'whatsapp'))
		@include('dev.partials.components.buttons.whatsapp')
	@endif

    @if($modals === true)
        @section('modal')
            @include('dev.partials.layouts.modal.c2c')
            @include('dev.partials.layouts.modal.c2c-velocidades')
            @include('dev.partials.layouts.modal.cobertura')
            @include('dev.partials.layouts.modal.rgpd-config')
            @include('dev.partials.layouts.modal.info-basica-privacidad')
            @include('dev.partials.layouts.modal.privacy')
            @include('dev.partials.layouts.modal.loaded-content')
            @include('dev.partials.layouts.modal.legal')
            @include('dev.partials.layouts.modal.response')
            @include('dev.partials.layouts.modal.manual')
			@include('dev.partials.layouts.modal.retencion')
        @show
    @endif

	<div id="current-phone" class="d-none">{{$phone_formatted}}</div>
	<div id="current-phone-link" class="d-none">{{$phone}}</div>
</div>
@section('footer-scripts')
	<script type="text/javascript">

      var jsToLoad = ['js/dist/generica.bundle.js'];

      function attachJsOnLoad() {
        for (var i = 0; i < jsToLoad.length; i++) {
          var element = document.createElement("script");
          element.src = jsToLoad[i];
          document.body.appendChild(element);
        }
      }

      function initScripts() {
        if (window.addEventListener) {
          window.addEventListener("load", attachJsOnLoad, false);
        } else if (window.attachEvent) {
          window.attachEvent("onload", attachJsOnLoad);
        } else {
          window.onload = attachJsOnLoad;
        }
      }

      initScripts();
	</script>
@show
</body>
</html>
