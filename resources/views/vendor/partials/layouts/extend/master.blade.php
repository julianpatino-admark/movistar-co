@php $nav = isset($nav)?$nav:true; $header_phone = isset($header_phone)?$header_phone:true; $phone = ($header_phone === true)?$phone:"0"; $main_c2c = isset($main_c2c)?$main_c2c:true; @endphp<!doctype html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=2,minimum-scale=1"><meta http-equiv="X-UA-Compatible" content="ie=edge"><meta name="facebook-domain-verification" content="u1y6tiqbwjdq7da92oq6cg5t8w7ybq"><meta id="provider" name="provider" content="{{$provider}}"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;500;700;900&display=swap" rel="stylesheet">@section('metadata') @show</head><body><div id="main">@include("vendor.partials.layouts.header.top-header") @include('vendor.partials.layouts.header.header') @include('vendor.partials.layouts.navbar.mobile-nav') @if($main_c2c === true) @include('vendor.partials.layouts.c2c.main') @include('vendor.partials.layouts.cta.desktop-sticky') @endif @yield('content') @include('vendor.partials.layouts.footer.footer') @include('vendor.partials.layouts.cta.mobile-fixed') @section('modal') @include('vendor.partials.layouts.modal.c2c') @include('vendor.partials.layouts.modal.rgpd-config') @include('vendor.partials.layouts.modal.info-basica-privacidad') @include('vendor.partials.layouts.modal.privacy') @include('vendor.partials.layouts.modal.loaded-content') @include('vendor.partials.layouts.modal.legal') @include('vendor.partials.layouts.modal.response') @show<div id="current-phone" class="d-none">{{$phone_formatted}}</div><div id="current-phone-link" class="d-none">{{$phone}}</div><div data-toggle="rgpd-dialog"></div></div>@section('footer-scripts')<script type="text/javascript">var jsToLoad = ['js/dist/generica.bundle.js'];

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

      initScripts();</script>@show</body></html>