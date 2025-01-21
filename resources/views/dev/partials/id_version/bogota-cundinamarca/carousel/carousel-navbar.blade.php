@extends("dev.partials.id_version.main-carousel-nav")

@section("navitems")
    <li class="@if(request()->path() == 'antioquia-eje-cafetero') active @endif">
        <a href="/antioquia-eje-cafetero?{{request()->getQueryString()}}">
            <b>Internet</b>
            Fibra
        </a>
    </li>
    <li class="@if(request()->path() == 'antioquia-eje-cafetero/duo') active @endif">
        <a href="/antioquia-eje-cafetero/duo?{{request()->getQueryString()}}">
            <b>Pack Digital</b>
            Fibra + Movistar TV App
        </a>
    </li>
    <li class="@if(request()->path() == 'antioquia-eje-cafetero/trio') active @endif">
        <a href="/antioquia-eje-cafetero/trio?{{request()->getQueryString()}}">
            <b>Trio</b>
            Fibra + Telefonía + TV
        </a>
    </li>
@endsection