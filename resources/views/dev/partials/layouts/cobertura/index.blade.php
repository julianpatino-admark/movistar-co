<section class="banner-cobertura">
    <div class="banner-cobertura_container">
        <div class="container">
            <h1>Estas a un paso de contratar tus servicios</h1>
            <h2>Ingresa tus datos y te llamaremos:</h2>
        </div>

        <form id="cobertura-form"
              method="post"
              data-toggle="form-simple"
              class="form form-cobertura"
              data-layer-page="/c2c/cobertura/conversion"
              action="{{url('/api/form/send')}}"
        >
            {{csrf_field()}}
            <input type="hidden" name="c2c" value="COBERTURA">
            <input type="hidden" name="id_version" value="{{$id_version}}">
            <input type="hidden" name="tsource" value="{{$tsource}}">
            <input type="hidden" name="batch_id" value="MOVISTARCO_KDMA_C2CLN_Q12">


            <div class="container">
                <div class="form-custom-group">
                    <input class="form-control small-inpt" type="text" name="phone" placeholder="* Número celular" required/>
                </div>

                <div class="form-cobertura_dual-input">
                    <div class="form-custom-group">
                        <input class="form-control" type="text" name="escliente" placeholder="* Eres cliente Movistar?" required/>
                    </div>

                    <div class="form-custom-group">
                        <select class="form-select" name="servicios">
                            <option hidden selected>¿Qué servicio buscas?</option>
                            <option value="internet">internet fibra</option>
                            <option value="movil">movil</option>
                        </select>
                    </div>
                </div>

                <input class="form-control" id="inptAddress" type="text" name="direccion" data-set="autocomplete-address" placeholder="Escribe tu dirección" required/>

                <a
                        href="#"
                        class="geo-link-current"
                        data-set="current-position"
                        data-target="inptAddress"
                >
                    @include("dev.partials.components.icons.market-map")
                    <span class="mx-2">Usar mi ubicación actual</span>
                </a>
            </div>
            <div class="map" id="gmp-map"></div>
            <div class="container">
                <div class="form-cobertura_specialaddr">
                    <input type="checkbox" name="specialaddr" id="checkSpecialAddr" data-toggle="toggle-enabled" data-elements="#inptDireccionAdicional">
                    <label for="specialaddr" class="text-xxs">
                        Mi dirección tiene especificaciones especiales ( Torre, Apto, Int, etc )
                    </label>
                </div>
                <input class="form-control small-inpt" type="text" id="inptDireccionAdicional" name="direccionAdicional" placeholder="Apto 502, torre 1, piso 3, etc" disabled  required/>

                <div class="form-cobertura_tyc">
                    <input type="checkbox" name="legal" id="legal" required>
                    <label for="legal">
                        Acepto
                        <a
                                href="#"
                                data-toggle="modal"
                                data-target="#modal-text"
                                data-content="{{url('/privacy')}}"
                                data-modal-title="Política de Privacidad"
                                title="Política de privacidad"
                        >
                            política de privacidad
                        </a>
                        y tratamiento de
                        <a
                                href="#"
                                data-toggle="modal"
                                data-target="#modal-text"
                                data-content="{{url('/privacy')}}"
                                data-modal-title="Política de Privacidad"
                                title="Política de privacidad"
                        >
                            datos personales.
                        </a>
                    </label>
                    <label for="legal" class="error d-block"></label>
                </div>

                <div class="form-cobertura_cta">
                    <button
                            id="btn-submit-cobertura-form"
                            class="btn-form"
                            data-c2c="TE LLAMAMOS"
                    >
                        <div class="btn-form_content font-family-bold">
                            Llámame
                        </div>
                        <span class="btn-form_loader">
							<span class="loader"></span>
						</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

