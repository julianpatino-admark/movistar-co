@extends('monitor.auth.layout', ['symbol' => 'mail'])
@section('title', 'Recuperar acceso')
@section('auth_content')
<span class="eyebrow">RECUPERA TU ACCESO</span>
<h2>¿Olvidaste tu contraseña?</h2>
<p class="auth-description">{{ config('monitor.password_reset_email_enabled') ? 'Ingresa el correo de tu cuenta para solicitar un enlace y crear una nueva contraseña.' : 'Podemos ayudarte a recuperar el acceso a tu espacio de trabajo.' }}</p>
@include('monitor.partials.messages')
@if (config('monitor.password_reset_email_enabled'))
<form method="post" action="{{ route('password.email') }}" class="form-stack">
    @csrf
    <label for="email">Correo de tu cuenta</label>
    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" placeholder="nombre@empresa.com" required autofocus maxlength="255">
    <button class="button button--primary button--full" type="submit">Enviar enlace @include('monitor.partials.icon', ['name' => 'arrow'])</button>
</form>
@else
    <div class="notice notice--info" role="status">@include('monitor.partials.icon', ['name' => 'mail'])<span>La recuperación por correo aún no está disponible. Solicita al administrador que restablezca tu acceso.</span></div>
@endif
<a class="back-link" href="{{ route('login') }}">@include('monitor.partials.icon', ['name' => 'back']) Volver a iniciar sesión</a>
@endsection
