<nav class="carousel-ciudades bogota">
    <ul>
        <li class="@if(request()->path() == '/') active @endif">
            <a href="/?{{request()->getQueryString()}}">Nacional</a>
        </li>
        <li class="@if(str_contains(request()->path(), 'bogota-cundinamarca')) active @endif">
            <a href="/bogota-cundinamarca?{{request()->getQueryString()}}">Bogotá y Cundinamarca</a>
        </li>
    </ul>
</nav>

<nav class="carousel-navbar">
    <ul>
        <li class="@if(request()->path() == 'bogota-cundinamarca') active @endif">
            <a href="/bogota-cundinamarca?{{request()->getQueryString()}}">
                <b>INTERNET</b>
                FIBRA
            </a>
        </li>
        <li class="@if(request()->path() == 'bogota-cundinamarca/duo') active @endif">
            <a href="/bogota-cundinamarca/duo?{{request()->getQueryString()}}">
                <b>DUO</b>
                FIBRA + FIJO
            </a>
        </li>
        <li class="@if(request()->path() == 'bogota-cundinamarca/trio') active @endif">
            <a href="/bogota-cundinamarca/trio?{{request()->getQueryString()}}">
                <b>TRIO</b>
                FIBRA + FIJO + TV
            </a>
        </li>
    </ul>
</nav>