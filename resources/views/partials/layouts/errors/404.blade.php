<main class="not-found" id="not-found-content">
    <div class="not-found__inner">
        <div class="not-found__image" aria-hidden="true">
            <img src="{{ Vite::asset('resources/img/error/redesign/not-found.png') }}" width="2999" height="2307" alt="" fetchpriority="high">
        </div>
        <div class="not-found__content">
            <h1>Página no encontrada</h1>
            <p>Lo sentimos, no se ha podido encontrar la página solicitada. Por favor, regrese a la página de inicio.</p>
            <a href="{{ url('/') . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}" class="movil-button not-found__home">Llévame a la home</a>
        </div>
    </div>
</main>
