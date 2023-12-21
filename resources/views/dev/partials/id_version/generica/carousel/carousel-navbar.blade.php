<nav class="carousel-navbar">
    <ul>
        <li class="@if(request()->path() == '/') active @endif">
            <a href="/?{{request()->getQueryString()}}">INTERNET FIBRA</a>
        </li>
        <li class="@if(request()->path() == 'duo-fibra') active @endif">
            <a href="/duo-fibra?{{request()->getQueryString()}}">INTERNET FIBRA + FIJO</a>
        </li>
        <li class="@if(request()->path() == 'trio-fibra') active @endif">
            <a href="/trio-fibra?{{request()->getQueryString()}}">INTERNET FIBRA + FIJO + TV</a>
        </li>
    </ul>
</nav>