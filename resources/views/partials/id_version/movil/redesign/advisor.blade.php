<div class="movil-help">
    <picture class="hogar-help__background" aria-hidden="true">
        <source media="(min-width: 480px)" srcset="{{ Vite::asset('resources/img/hogar/redesign/advisor-background-tablet.svg') }}">
        <img src="{{ Vite::asset('resources/img/hogar/redesign/advisor-background-mobile.svg') }}" alt="" loading="lazy">
    </picture>
<section class="movil-advisor" aria-labelledby="movil-advisor-title">
    <div class="movil-advisor__inner">
        <div class="movil-advisor__copy">
            <h2 id="movil-advisor-title">¿No decides qué<br> plan contratar?</h2>
            <p>Te asesoramos sobre lo que necesitas.</p>
            <button type="button" class="movil-button movil-button--yellow" data-toggle="modal" data-target="#modal-c2c" data-c2c="{{ $advisorC2c ?? 'ASESORIA PLANES POSPAGO' }}" data-tag-page="{{ $advisorTag ?? '/modal/movil/asesoria/c2c' }}">¡Ayúdenme a elegir!</button>
        </div>
        <div class="movil-advisor__image">
            <img src="{{ Vite::asset('resources/img/movil/redesign/advisor.png') }}" alt="Mujer con un computador portátil" loading="lazy" width="326" height="407">
        </div>
    </div>
</section>
<aside class="movil-home" aria-labelledby="movil-home-title">
    <div class="movil-home__card">
        <picture class="movil-home__background">
            <source media="(min-width: 480px) and (max-width: 1199px)" srcset="{{ Vite::asset('resources/img/movil/redesign/home-tablet-background.svg') }}" width="375" height="222">
            <img src="{{ Vite::asset('resources/img/movil/redesign/home-background.svg') }}" width="308" height="182" alt="" loading="lazy">
        </picture>
        <h2 id="movil-home-title">{{ ($mobileInfo ?? false) ? 'Pásate a Móvil' : 'Internet fibra para tu hogar' }}</h2>
        <div class="movil-home__description">
            <picture>
                @if($mobileInfo ?? false)
                    <source media="(min-width: 1200px)" srcset="{{ Vite::asset('resources/img/movil/redesign/mobile-info-desktop.svg') }}">
                    <source media="(min-width: 480px)" srcset="{{ Vite::asset('resources/img/movil/redesign/mobile-info-tablet.svg') }}">
                    <img src="{{ Vite::asset('resources/img/movil/redesign/mobile-info-mobile.svg') }}" alt="" loading="lazy">
                @else
                    <source media="(min-width: 1200px)" srcset="{{ Vite::asset('resources/img/movil/redesign/wifi-desktop.svg') }}" width="41" height="30">
                    <source media="(min-width: 480px)" srcset="{{ Vite::asset('resources/img/hogar/redesign/home-wifi-tablet.svg') }}" width="50.2663" height="36.2828">
                    <img src="{{ Vite::asset('resources/img/movil/redesign/wifi.svg') }}" width="41.2854" height="29.8002" alt="" loading="lazy">
                @endif
            </picture>
            @if($mobileInfo ?? false)
                <p>Más GIGAS para disfrutar<br>con Movistar Pospago</p>
            @else
                <p>Velocidad simétrica para<br>tu entretenimiento</p>
            @endif
        </div>
        @if($mobileInfo ?? false)
            <button type="button" class="movil-button movil-button--yellow" data-toggle="modal" data-target="#modal-c2c" data-c2c="INFORMACION MOVISTAR POSPAGO" data-tag-page="/modal/movil/informacion/c2c">Quiero información</button>
        @else
            <button type="button" class="movil-button movil-button--yellow" data-toggle="modal" data-target="#modal-c2c" data-c2c="{{ $homeInformationC2c ?? 'INFORMACION INTERNET HOGAR' }}" data-tag-page="{{ $homeInformationTag ?? '/modal/internet-hogar/informacion/c2c' }}">Quiero información</button>
        @endif
    </div>
</aside>
</div>
