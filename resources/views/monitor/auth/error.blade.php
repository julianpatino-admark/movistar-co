@extends('monitor.auth.layout', ['symbol' => 'alert'])
@php
    [$heading, $description] = match ($statusCode) {
        403 => ['Tu cuenta no tiene acceso', 'Solicita al administrador que habilite el permiso para consultar el monitor.'],
        419 => ['Tu sesión ha caducado', 'Vuelve a iniciar sesión para continuar de forma segura.'],
        default => ['Hagamos una breve pausa', 'Se alcanzó el límite de intentos. Espera unos minutos antes de volver a intentarlo.'],
    };
@endphp
@section('title', $heading)
@section('auth_content')
<span class="eyebrow">ACCESO AL MONITOR</span>
<h2>{{ $heading }}</h2>
<p class="auth-description">{{ $description }}</p>
@auth
<form method="post" action="{{ route('logout') }}">@csrf<button class="button button--primary button--full" type="submit">Cerrar sesión @include('monitor.partials.icon', ['name' => 'logout'])</button></form>
@else
<a class="button button--primary button--full" href="{{ route('login') }}">Volver a iniciar sesión @include('monitor.partials.icon', ['name' => 'arrow'])</a>
@endauth
@endsection
