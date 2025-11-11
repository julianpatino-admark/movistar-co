<div class="main-banner">
    <div class="container">
        <div class="offer-promo">
            <div class="main-banner_liga-text">
                <h1>
                    <span>VIVE LA PASIÓN</span>
                    Y ADQUIERE <br>
                    TU PAQUETE...
                </h1>
                @include('dev.partials.components.icons.logo.liga1-negative-logo')
            </div>
            <x-offer-banner-card>
                <x-slot:bottomleft>
                    <h1>
                        <small>S/</small>131
                    </h1>
                    <p>al mes</p>
                </x-slot>
                <x-slot:bottomright>
                <h1>
                    150
                    <small>
                        <span>Mbps</span>
                        de velocidad
                    </small>
                </h1>
            </x-slot>
            </x-offer-banner-card>
        </div>
        @include('dev.partials.layouts.c2c.main', [
            "c2c_text" => array(
                "title" => "3 Play",
                "description" => "¡Adquiere Liga1 y vive la pasión con ClaroTV!"
            )
        ])
    </div>
</div>
