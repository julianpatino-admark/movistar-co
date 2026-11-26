@extends('monitor.shell')
@section('title', 'Mi cuenta')
@section('breadcrumb', 'Mi cuenta')
@section('content')
<div class="page-heading"><div><span class="eyebrow">TU ESPACIO PERSONAL</span><h1>Mi cuenta</h1><p>Gestiona la contraseña con la que accedes al monitor.</p></div></div>
<div class="account-grid">
    <section class="panel account-identity"><span class="avatar avatar--large">{{ mb_substr(auth()->user()->name, 0, 1) }}</span><h2>{{ auth()->user()->name }}</h2><p>{{ auth()->user()->email }}</p><span class="badge badge--success">@include('monitor.partials.icon', ['name' => 'check']) Acceso al monitor habilitado</span><hr><p>Para cambiar tu nombre, correo o permisos, contacta al administrador.</p></section>
    <section class="panel account-password"><div class="section-heading"><div><h2>Actualizar contraseña</h2><p>Usa al menos 12 caracteres con letras y números.</p></div><span class="section-symbol">@include('monitor.partials.icon', ['name' => 'lock'])</span></div>
    @include('monitor.partials.messages')
    <form method="post" action="{{ route('user-password.update') }}" class="form-stack">@csrf @method('PUT')
        <label for="current_password">Contraseña actual</label><div class="password-field"><input id="current_password" type="password" name="current_password" autocomplete="current-password" required><button class="password-toggle" type="button" data-password-toggle="current_password" aria-label="Mostrar contraseña" aria-pressed="false">@include('monitor.partials.icon', ['name' => 'eye'])</button></div>
        <label for="password">Nueva contraseña</label><div class="password-field"><input id="password" type="password" name="password" autocomplete="new-password" required minlength="12"><button class="password-toggle" type="button" data-password-toggle="password" aria-label="Mostrar contraseña" aria-pressed="false">@include('monitor.partials.icon', ['name' => 'eye'])</button></div>
        <label for="password_confirmation">Confirmar nueva contraseña</label><input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required minlength="12">
        <p class="field-hint">Las otras sesiones deberán iniciar sesión de nuevo después del cambio.</p>
        <button class="button button--primary" type="submit">Guardar cambios @include('monitor.partials.icon', ['name' => 'check'])</button>
    </form></section>
</div>
@endsection
