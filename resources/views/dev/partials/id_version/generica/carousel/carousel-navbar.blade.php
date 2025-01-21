<nav class="carousel-ciudades">
    <ul>
        <li class="@if(!str_contains(request()->path(), 'antioquia-eje-cafetero')) active @endif">
            <a href="/?{{request()->getQueryString()}}">Nacional</a>
        </li>
        <li class="@if(request()->path() == 'antioquia-eje-cafetero') active @endif">
            <a href="/antioquia-eje-cafetero?{{request()->getQueryString()}}">Antioquia y Eje Cafetero</a>
        </li>
    </ul>
</nav>

<nav class="carousel-navbar">
    <ul>
        <li class="@if(request()->path() == 'internet-hogar') active @endif">
            <a href="/internet-hogar?{{request()->getQueryString()}}">
                <b>Internet</b>
                Fibra
            </a>
        </li>
        <li class="@if(request()->path() == 'duo-fibra') active @endif">
            <a href="/duo-fibra?{{request()->getQueryString()}}">
                <b>Pack Digital</b>
                Fibra + Movistar TV App
            </a>
        </li>
        <li class="@if(request()->path() == 'trio-fibra') active @endif">
            <a href="/trio-fibra?{{request()->getQueryString()}}">
                <b>Trio</b>
                Fibra + Telefonía + TV
            </a>
        </li>
    </ul>
</nav>
