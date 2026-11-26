@extends('monitor.auth.layout')
@section('title', 'Iniciar sesión')
@section('auth_content')
<span class="eyebrow">TU ESPACIO DE TRABAJO</span>
<h2>Bienvenido de nuevo</h2>
<p class="auth-description">Ingresa con tu cuenta para consultar el estado de los leads.</p>
@include('monitor.partials.messages')
<form method="post" action="{{ route('login.store') }}" class="form-stack">
    @csrf
    <label for="email">Correo electrónico</label>
    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" placeholder="nombre@empresa.com" required autofocus maxlength="255" @if($errors->has('email')) aria-invalid="true" @endif>
    <div class="label-row"><label for="password">Contraseña</label><a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a></div>
    <div class="password-field"><input id="password" name="password" type="password" autocomplete="current-password" required><button class="password-toggle" type="button" data-password-toggle="password" aria-label="Mostrar contraseña" aria-pressed="false">@include('monitor.partials.icon', ['name' => 'eye'])</button></div>
    <button class="button button--primary button--full" type="submit">Iniciar sesión @include('monitor.partials.icon', ['name' => 'arrow'])</button>
</form>
<p class="auth-help">¿Necesitas una cuenta? Solicita acceso al administrador.</p>
@endsection
