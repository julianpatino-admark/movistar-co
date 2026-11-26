@extends('monitor.auth.layout')
@section('title', 'Nueva contraseña')
@section('auth_content')
<span class="eyebrow">UN NUEVO COMIENZO</span>
<h2>Crea tu nueva contraseña</h2>
<p class="auth-description">Elige una contraseña de al menos 12 caracteres que incluya letras y números.</p>
@include('monitor.partials.messages')
<form method="post" action="{{ route('password.update') }}" class="form-stack">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <label for="email">Correo de tu cuenta</label>
    <input id="email" type="email" name="email" value="{{ old('email', $request->input('email')) }}" required autocomplete="username" maxlength="255">
    <label for="password">Nueva contraseña</label>
    <div class="password-field"><input id="password" type="password" name="password" autocomplete="new-password" required minlength="12"><button class="password-toggle" type="button" data-password-toggle="password" aria-label="Mostrar contraseña" aria-pressed="false">@include('monitor.partials.icon', ['name' => 'eye'])</button></div>
    <label for="password_confirmation">Confirmar nueva contraseña</label>
    <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required minlength="12">
    <button class="button button--primary button--full" type="submit">Guardar contraseña @include('monitor.partials.icon', ['name' => 'arrow'])</button>
</form>
<a class="back-link" href="{{ route('login') }}">@include('monitor.partials.icon', ['name' => 'back']) Volver a iniciar sesión</a>
@endsection
