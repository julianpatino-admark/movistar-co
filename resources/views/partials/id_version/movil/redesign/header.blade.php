@php($keyword = request()->query('keyword', ''))
<a class="movil-skip-link" href="#{{ $contentId ?? 'movil-content' }}">Ir al contenido</a>
<header class="movil-header" id="header">
    <div class="movil-header__notice">
        Canal exclusivo de ventas <span aria-hidden="true">|</span> Agente oficial
    </div>
    <div class="movil-header__inner">
        <a class="movil-header__brand" href="{{ url('/') . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}" aria-label="Movistar, inicio">
            <picture>
                <source media="(min-width: 1200px)" srcset="{{ Vite::asset('resources/img/internet-movil/redesign/brand-desktop.svg') }}">
                <source media="(min-width: 480px)" srcset="{{ Vite::asset('resources/img/internet-movil/redesign/brand-tablet.svg') }}">
                <img src="{{ Vite::asset('resources/img/internet-movil/redesign/brand-mobile.svg') }}" alt="Movistar y Tigo">
            </picture>
        </a>
        @if(strlen($phone) >= 9 && $keyword !== 'nonum')
            <a class="movil-header__phone goo-phone" href="tel:{{ $phone }}" data-event="phone_cabecera_click">
                <span>Línea de ventas</span>
                <strong>{{ $phone_formatted }}</strong>
            </a>
        @endif
        <nav class="movil-header__desktop-navigation" aria-label="Servicios principales">
            @include('partials.layouts.navbar.nav-items', ['navigationIcons' => 'header'])
        </nav>
        <button class="movil-header__menu collapsed" type="button" data-toggle="collapse" data-target="#navbarMobileCollapse" aria-controls="navbarMobileCollapse" aria-expanded="false" aria-label="Abrir menú de servicios">
            <img src="{{ Vite::asset('resources/img/movil/redesign/menu.svg') }}" width="37" height="26" alt="">
        </button>
    </div>
    <nav class="collapse movil-header__navigation" id="navbarMobileCollapse" aria-label="Menú principal">
        @include('partials.layouts.navbar.nav-items', ['navigationIcons' => 'header'])
    </nav>
</header>
