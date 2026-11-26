@extends('monitor.layout')
@section('body_class', 'dashboard')
@section('body')
<aside class="sidebar">
    @include('monitor.partials.brand')
    <p class="nav-label">ESPACIO DE TRABAJO</p>
    <nav aria-label="Navegación del monitor">
        <a class="nav-item {{ request()->routeIs('gocontact.monitor') ? 'is-active' : '' }}" href="{{ route('gocontact.monitor') }}" @if(request()->routeIs('gocontact.monitor')) aria-current="page" @endif>@include('monitor.partials.icon', ['name' => 'grid']) Monitoreo de leads</a>
        <a class="nav-item {{ request()->routeIs('monitor.account') ? 'is-active' : '' }}" href="{{ route('monitor.account') }}" @if(request()->routeIs('monitor.account')) aria-current="page" @endif>@include('monitor.partials.icon', ['name' => 'user']) Mi cuenta</a>
    </nav>
    <div class="sidebar__bottom"><span class="connection-label"><i></i> Integración GoContact</span><a class="nav-item" href="{{ url('/') }}">@include('monitor.partials.icon', ['name' => 'back']) Ir a la tienda</a><form method="post" action="{{ route('logout') }}">@csrf<button class="nav-item" type="submit">@include('monitor.partials.icon', ['name' => 'logout']) Cerrar sesión</button></form></div>
</aside>
<div class="workspace">
    <header class="workspace-topbar">
        <div class="workspace-breadcrumb">Operación <span>/</span> <strong>@yield('breadcrumb', 'Monitoreo')</strong></div>
        <div class="auth-mobile-brand">@include('monitor.partials.brand')</div>
        <div class="user-chip"><span class="avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</span><div><strong>{{ auth()->user()->name }}</strong><small>Cuenta de monitoreo</small></div></div>
        <details class="mobile-menu"><summary aria-label="Abrir navegación">@include('monitor.partials.icon', ['name' => 'grid'])</summary><nav aria-label="Navegación móvil"><a href="{{ route('gocontact.monitor') }}">Monitoreo de leads</a><a href="{{ route('monitor.account') }}">Mi cuenta</a><form method="post" action="{{ route('logout') }}">@csrf<button type="submit">Cerrar sesión</button></form></nav></details>
    </header>
    <main id="main-content" class="workspace-main">@yield('content')</main>
    <footer class="workspace-footer"><span>Ofertas Tienda · Monitor de leads</span><span>Las fechas se muestran en hora de Colombia.</span></footer>
</div>
@endsection
