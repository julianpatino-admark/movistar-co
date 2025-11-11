<div class="card-offer_max">
    
    <div class="card-offer_label">
        @include('dev.partials.components.icons.cards.max-text')
    </div>

    <div class="card-offer_wrapper">

        <div class="card-offer_header">
            <p>INTERNET</p>
            <h2 class="title">
                25 GB
                <small>SIN FULLCLARO</small>
            </h2>

            <h3 class="price-number"><b>s/</b><span>39.90</span>/mes</h3>
        </div>

        <div class="card-offer_body">

            <div class="card-offer_body-speed">
                <span class="speed-text">TODO ILIMITADO</span>
                Aplicaciones, Llamadas y Mensajes
            </div>

            <p class="card-offer_body-label">
                Bono 30GB x6 meses
            </p>

            <ul class="card-offer_body-list">
                <li>
                    <h4>
                        Internet con <b>Full<span class="text-red">Claro</span></b>
                    </h4>
                    <p>37.5GB</p>
                </li>
                <li>
                    <h4>Paramount+</h4>
                    <p>
                        <b><span>en</span> <span class="text-red">Claro</span>Video</b>
                        <span>x24 meses</span>
                    </p>
                </li>
                <li>
                    <h4>Minutos<br> Internacional</h4>
                    <p>
                        350
                    </p>
                </li>
                <li>
                    <h4>Cobertura<br> Internacional</h4>
                    <p>
                        <span>
                            Latinoamérica y <br>
                            Zona Andina
                        </span>
                    </p>
                </li>
                <li>
                    <h4>
                        Redes Sociales Ilimitadas<br>
                        (Fotos)
                    </h4>
                    <p>
                        @include('dev.partials.components.icons.cards.rrss-mid')
                    </p>
                </li>
                <li>
                    <h4>
                        Apps<br>
                        Ilimitadas
                    </h4>
                    <p>
                        @include('dev.partials.components.icons.cards.rrss-min')
                    </p>
                </li>
            </ul>

        </div>

        <div class="card-offer_footer">
            <button
                class="btn-flex btn-accent"
                data-c2c="offer-one"
                data-show-element="#modal-header-phone"
                data-conversion-event="c2c_offer_one"
                data-toggle="modal"
                data-target="#modal-c2c"
            >
                LO QUIERO
            </button>
        </div>
    </div>
    

</div>
