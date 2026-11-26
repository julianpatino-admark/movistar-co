@extends('monitor.layout')
@section('body_class', 'auth-page')
@section('body')
<aside class="auth-story">
    @include('monitor.partials.brand')
    <div class="auth-story__content">
        <span class="eyebrow">VISIBILIDAD EN CADA PASO</span>
        <h1>Cada lead,<br>en su lugar<span>.</span></h1>
        <p>Un solo espacio para seguir los envíos, consultar su destino y entender cada resultado.</p>
        <div class="journey" aria-hidden="true">
            <div class="journey__line"></div>
            <div class="journey__step"><span>@include('monitor.partials.icon', ['name' => 'check'])</span><div><strong>Recepción</strong><small>El lead queda registrado</small></div><i></i></div>
            <div class="journey__step"><span>@include('monitor.partials.icon', ['name' => 'database'])</span><div><strong>Asignación</strong><small>Cada envío conserva su destino</small></div><i></i></div>
            <div class="journey__step"><span>@include('monitor.partials.icon', ['name' => 'grid'])</span><div><strong>Seguimiento</strong><small>Resultados siempre a la vista</small></div><i></i></div>
        </div>
    </div>
    <p class="auth-story__footer">Ofertas Tienda <span>·</span> Operación Movistar</p>
</aside>
<main id="main-content" class="auth-main">
    <div class="auth-mobile-brand">@include('monitor.partials.brand')</div>
    <div class="auth-card">
        <span class="auth-symbol">@include('monitor.partials.icon', ['name' => $symbol ?? 'lock'])</span>
        @yield('auth_content')
    </div>
    <p class="auth-footnote">@include('monitor.partials.icon', ['name' => 'lock']) Acceso exclusivo para personal autorizado.</p>
    <a class="auth-store-link" href="{{ url('/') }}">Volver a Ofertas Tienda @include('monitor.partials.icon', ['name' => 'arrow'])</a>
</main>
@endsection
