<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>@yield('title', 'Monitoreo') · Ofertas Tienda</title>
    @vite(['resources/sass/monitor.scss', 'resources/js/monitor.js'])
</head>
<body class="monitor @yield('body_class')">
    <a class="skip-link" href="#main-content">Saltar al contenido</a>
    @yield('body')
</body>
</html>
