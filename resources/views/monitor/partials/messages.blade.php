@if (session('status'))
    <div class="notice notice--success" role="status">@include('monitor.partials.icon', ['name' => 'check'])<span>{{ session('status') === 'password-updated' ? 'Tu contraseña se actualizó correctamente.' : session('status') }}</span></div>
@endif
@if ($errors->any() || $errors->getBag('updatePassword')->any())
    <div class="notice notice--error" role="alert">
        @include('monitor.partials.icon', ['name' => 'alert'])
        <div>@foreach (array_merge($errors->all(), $errors->getBag('updatePassword')->all()) as $error)<p>{{ $error }}</p>@endforeach</div>
    </div>
@endif
