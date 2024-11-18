<nav class="carousel-navbar">
    <ul>
        <li class="@if(request()->path() == 'internet-movil') active @endif">
            <a href="/internet-movil?{{request()->getQueryString()}}">
                <b>Solo Internet + Pospago</b>
            </a>
        </li>
        <li class="@if(request()->path() == 'internet-movil/duo') active @endif">
            <a href="/internet-movil/duo?{{request()->getQueryString()}}">
                <b>Dúo + Pospago</b>
            </a>
        </li>
        <li class="@if(request()->path() == 'internet-movil/trio') active @endif">
            <a href="/internet-movil/trio?{{request()->getQueryString()}}">
                <b>Trío + Pospago</b>
            </a>
        </li>
    </ul>
</nav>