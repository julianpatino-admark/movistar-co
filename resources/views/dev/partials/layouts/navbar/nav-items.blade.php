@php
    $path = request()->path();
    $internetHogarPath = ['duo-fibra', 'internet-hogar','trio-fibra'];
    $isValid = array_filter($internetHogarPath, fn($keyword) => str_contains($path, $keyword));

@endphp

<ul>
    <li class="nav-item @if(str_contains($path, '/') || str_contains($path, 'internet-movil')) active font-weight-bold @endif">
        <a class="nav-link" href="/internet-movil?{{request()->getQueryString()}}">
            <div class="icono-default movistar"></div>
            Internet Hogar + Móvil
        </a>
    </li>
    <li class="nav-item @if($isValid) active font-weight-bold @endif">
        <a class="nav-link" href="/internet-hogar?{{request()->getQueryString()}}">
            <div class="icono-default wifi"></div>
            Internet Hogar
        </a>
    </li>
    <li class="nav-item @if($path == 'movil') active font-weight-bold @endif">
        <a class="nav-link" href="/movil?{{request()->getQueryString()}}">
            <div class="icono-default movil"></div>
            Móvil
        </a>
    </li>
</ul>

