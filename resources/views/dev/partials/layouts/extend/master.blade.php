@php
	$nav = isset($nav)?$nav:true;
	$header_phone = isset($header_phone)?$header_phone:true;
	$phone = ($header_phone === true)?$phone:"0";
	$main_c2c = isset($main_c2c)?$main_c2c:true;
@endphp

		<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="facebook-domain-verification" content="u1y6tiqbwjdq7da92oq6cg5t8w7ybq"/>
	<meta id="provider" name="provider" content="{{$provider}}">
	@section('metadata')
	@show
</head>
<body>
<div id="main">
	@include("dev.partials.layouts.header.top-header")
	@include('dev.partials.layouts.header.header')
	@if($nav === true)
		@include('dev.partials.layouts.navbar.nav')
	@endif
	@if($main_c2c === true)
		@include('dev.partials.layouts.c2c.main')
		@include('dev.partials.layouts.cta.desktop-sticky')
	@endif

	@yield('content')

	@include('dev.partials.layouts.footer.footer')
	@include('dev.partials.layouts.cta.mobile-fixed')

	@section('modal')
		@include('dev.partials.layouts.modal.c2c')
		@include('dev.partials.layouts.modal.rgpd-config')
		@include('dev.partials.layouts.modal.info-basica-privacidad')
		@include('dev.partials.layouts.modal.privacy')
		@include('dev.partials.layouts.modal.loaded-content')
		@include('dev.partials.layouts.modal.legal')
		@include('dev.partials.layouts.modal.response')
	@show

	<div id="current-phone" class="d-none">{{$phone_formatted}}</div>
	<div id="current-phone-link" class="d-none">{{$phone}}</div>

	<div data-toggle="rgpd-dialog"></div>
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
