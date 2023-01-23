<form id="{{ $id }}"
      method="post"
      data-toggle="form-simple"
      class="form @if(isset($class)){{$class}}@endif"
      data-layer-page="/c2c/principal/conversion"
      action="{{url('/api/form/send')}}">
    {{csrf_field()}}
    <input type="hidden" name="c2c" value="LLÁMAME GRATIS">
    <input type="hidden" name="id_version" value="{{$id_version}}">
    <input type="hidden" name="tsource" value="{{$tsource}}">
    <input type="hidden" name="batch_id" value="V_DIG_C2C{{$batch_suffix}}">


    <p class="form-simple_title">
        ¿Ya eres cliente?
    </p>

    <div class="mb-2">

        <div class="d-flex align-items-center justify-content-center">

            <div class="form-check">
                <input id="{{ $id }}-cliente" class="form-check-input" type="radio" name="escliente" required
                       data-toggle="enable-fields" data-enable="#{{ $id }}-motivo"
                       data-set="batch_id:V_DIG_CLIENTE{{$batch_suffix}}"
                       data-parent="#{{$id}}" value="si">
                <label class="form-check-label" for="{{ $id }}-cliente">Sí</label>
            </div>

            <div class="ms-1 me-1">
                <select id="{{ $id }}-motivo" name="Lote" class="form-control" data-set="batch_id"
                        data-parent="#{{$id}}"
                        data-company="" required="" disabled="">
                    <option value="" selected="">Seleccionar</option>
                    <option value="V_DIG_C2C{{$batch_suffix}}">Información de productos</option>
                    <option value="V_DIG_CLIENTE{{$batch_suffix}}">Gestiones de mi contrato</option>
                </select>
            </div>

            <div class="form-check">
                <input id="{{ $id }}-nocliente" class="form-check-input" type="radio" name="escliente"
                       data-toggle="enable-fields" data-disable="#{{ $id }}-motivo"
                       data-set="batch_id:V_DIG_C2C{{$batch_suffix}}"
                       data-parent="#{{$id}}" value="no">
                <label class="form-check-label" for="{{ $id }}-nocliente">No</label>
            </div>

        </div>

        <label for="escliente" class="error mb-2"></label>
    </div>

    <div class="mb-2">
        <input type="text" name="phone" class="form-control" placeholder="Teléfono" required data-rule-phone="col">
    </div>

    <div class="mb-2">
        <label class="text-xxs">
            <input type="checkbox" name="legal" required> Marcando esta casilla aceptas la
            <a class="text-xxs" href="#" data-toggle="modal" data-target="#modal-text"
               data-content="{{url('/privacy')}}" data-modal-title="Política de Privacidad"
               title="Política de privacidad">política de privacidad</a> de {{config('app.name')}} <a class="text-xxs"
                                                                                                      href="#"
                                                                                                      data-toggle="modal"
                                                                                                      data-target="#modal-info-basica-privacidad"
                                                                                                      data-modal-title="Política de Privacidad"
                                                                                                      title="Política de privacidad">+
                info</a></label>
        <label for="legal" class="error d-block"></label>
    </div>

    <div class="mb-2">
        <button class="form-control btn-form bg-degraded" data-c2c="TE LLAMAMOS">
            <div class="btn-form_content font-family-bold">
                Llámame GRATIS @include('dev.partials.components.icons.buttons.arrow-right')
            </div>
            <span class="btn-form_loader">
                <span class="loader"></span>
            </span>
        </button>
    </div>
</form>
