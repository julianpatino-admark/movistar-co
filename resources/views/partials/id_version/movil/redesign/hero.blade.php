<section class="movil-hero" aria-labelledby="movil-title">
    <div class="movil-hero__decoration" aria-hidden="true">
        <picture>
            <source media="(min-width: 1200px)" srcset="{{ Vite::asset('resources/img/movil/redesign/hero-offer-mask-desktop.svg') }}">
            <source media="(min-width: 480px)" srcset="{{ Vite::asset('resources/img/movil/redesign/hero-offer-mask-tablet.svg') }}">
            <img src="{{ Vite::asset('resources/img/movil/redesign/hero-offer-mask-mobile.svg') }}" alt="">
        </picture>
    </div>
    <div class="movil-hero__content">
        <h1 id="movil-title">Cámbiate a Pospago</h1>
        <p class="movil-hero__data" aria-label="60 GB">60GB</p>
        <button type="button" class="pospago-price" data-c2c="MOVIL DE 60 GB : 53.900" data-toggle="modal" data-target="#modal-c2c" data-test-id="calcula-banner-btn" data-tag-page="/modal/oferta-main-banner/c2c" aria-label="Quiero el plan Pospago de 60 GB por 53.900 pesos">
            <span class="pospago-price__currency" aria-hidden="true">$</span><strong aria-hidden="true">53</strong><span class="pospago-price__fraction" aria-hidden="true">.900<small>Cargo básico</small></span>
        </button>
        <a class="movil-hero__terms" href="#conditions">* Aplican términos y condiciones</a>
    </div>
    <aside class="movil-hero__form" aria-labelledby="movil-form-title">
        <h2 id="movil-form-title">¿Deseas comprar uno de nuestros planes?</h2>
        <label class="sr-only" for="c2c-movil-desktop-selectServicios">Elige tu servicio</label>
        <label class="sr-only" for="c2c-movil-desktop-phone">Número de celular</label>
        <label class="sr-only" for="c2c-movil-desktop-name">Nombres y apellidos</label>
        @include('partials.components.forms.simple', ['id' => 'c2c-movil-desktop', 'class' => 'form-simple', 'showServices' => true, 'submitText' => '¡Llámame!'])
    </aside>
</section>
