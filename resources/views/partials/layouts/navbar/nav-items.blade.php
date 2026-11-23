@php
    $navigationPage = request()->is('movil') ? 'movil' : (request()->is('internet-hogar') ? 'hogar' : 'internet-movil');
    $menuItems = [
        [
            'label' => 'Internet Hogar + Móvil',
            'url' => '/internet-movil',
            'icon' => 'movistar',
            'patterns' => [
                '/',
                'internet-movil*'
            ]
        ],
        [
            'label' => 'Internet Hogar',
            'url' => '/internet-hogar',
            'icon' => 'wifi',
            'patterns' => [
                'internet-hogar*', 
                'duo-fibra*', 
                'trio-fibra*', 
                'antioquia-eje-cafetero*'
            ]
        ],
        [
            'label' => 'Móvil',
            'url' => '/movil',
            'icon' => 'movil',
            'patterns' => ['movil']
        ],
    ];

@endphp

<ul>
    @foreach ($menuItems as $item)
        @php
            $isActive = request()->is($item['patterns']);
            $queryParams = request()->query();
            $queryString = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';
        @endphp

        <li class="nav-item {{ $isActive ? 'active font-weight-bold' : '' }}">
            <a class="nav-link" href="{{ $item['url'] . $queryString }}" @if($isActive) aria-current="page" @endif>
                @if(($navigationIcons ?? null) === 'header')
                    <img class="fiber-navigation-icon" src="{{ Vite::asset('resources/img/'.$navigationPage.'/redesign/header-'.$item['icon'].'.svg') }}" alt="">
                @elseif(($navigationIcons ?? null) === 'services')
                    <picture class="fiber-navigation-icon">
                        <source media="(min-width: 1200px)" srcset="{{ Vite::asset('resources/img/'.$navigationPage.'/redesign/navigation-'.$item['icon'].'-desktop.svg') }}">
                        <source media="(min-width: 480px)" srcset="{{ Vite::asset('resources/img/'.$navigationPage.'/redesign/navigation-'.$item['icon'].'-tablet.svg') }}">
                        <img src="{{ Vite::asset('resources/img/'.$navigationPage.'/redesign/navigation-'.$item['icon'].'-mobile.svg') }}" alt="">
                    </picture>
                @else
                <div class="icono-default {{ $item['icon'] }}"></div>
                @endif
                {{ $item['label'] }}
            </a>
        </li>
    @endforeach
</ul>
