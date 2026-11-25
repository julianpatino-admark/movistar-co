<main class="thankyou" id="thankyou-content">
    <div class="thankyou__inner">
        <div class="thankyou__content" id="thankyou_container">
            <h1>¡GRACIAS!</h1>
            <p class="thankyou__intro"><strong>Hemos recibido tu registro correctamente,</strong> te estaremos llamando en un lapso de 10 a 15 minutos para brindarte toda la información.</p>
            <p class="thankyou__hours">Nuestro horario de atención es de <strong>Lunes a Viernes</strong> de <strong>8:00 a.m. a 9:00 p.m / Sábados 9:00 a.m. a 4:00 p.m.</strong></p>
            <div class="thankyou__callback">
                <p>Pronto te llamaremos desde los siguientes números</p>
                <p class="thankyou__numbers"><a href="tel:3009162234">300 916 22 34</a><span aria-hidden="true">/</span><a href="tel:3009176610">300 917 66 10</a></p>
            </div>
            <a class="movil-button movil-button--yellow thankyou__home" href="{{ url('/') . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}">Volver al home</a>
        </div>
        <div class="thankyou__image" aria-hidden="true">
            <img src="{{ Vite::asset('resources/img/thankyou/redesign/couple.png') }}" width="1080" height="1105" alt="" fetchpriority="high">
        </div>
    </div>
</main>
