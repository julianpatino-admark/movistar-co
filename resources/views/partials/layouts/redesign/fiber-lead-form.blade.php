<aside class="movil-hero__form" aria-labelledby="{{ $heroPrefix }}-form-title">
    <h2 id="{{ $heroPrefix }}-form-title">¿Deseas comprar uno de nuestros planes?</h2>
    <label class="hogar-sr-only" for="c2c-{{ $heroPrefix }}-desktop-selectServicios">Elige tu servicio</label>
    <label class="hogar-sr-only" for="c2c-{{ $heroPrefix }}-desktop-phone">Número de celular</label>
    <label class="hogar-sr-only" for="c2c-{{ $heroPrefix }}-desktop-name">Nombres y apellidos</label>
    @include('partials.components.forms.simple', ['id' => 'c2c-'.$heroPrefix.'-desktop', 'class' => 'form-simple', 'showServices' => true, 'submitText' => $heroSubmitText ?? '¡Llámame!'])
</aside>
