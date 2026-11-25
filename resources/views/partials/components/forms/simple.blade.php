@php
    $showServices = isset($showServices) ? $showServices : true;
    $modalForm = $modalForm ?? false;
@endphp

<form id="{{ $id }}"
      method="post"
      data-toggle="form-simple"
      class="form @if(isset($class)){{$class}}@endif"
      data-layer-page="{{ $formLayerPage ?? '/c2c/principal/conversion' }}"
      action="{{url('/api/form/send')}}">
    {{csrf_field()}}
    <input type="hidden" name="c2c" value="LLÁMAME GRATIS">
    <input type="hidden" name="id_version" value="{{$id_version}}">
    <input type="hidden" name="tsource" value="{{$tsource}}">
    <input type="hidden" name="batch_id" value="MOVISTARCO_KDMA_C2CLN_Q12">

    @if($showServices)
        <div class="{{ $modalForm ? 'lead-modal-field lead-modal-field--service' : 'mb-2' }}">
            @if($modalForm)<label class="sr-only" for="{{ $id }}-selectServicios">Elige tu servicio</label>@endif
            <label class="input-group-text statusLoader d-none"> <i class="select-loader"></i></label>
            <select
                id="{{ $id }}-selectServicios"
                name="servicios"
                class="form-select"
                required
            >
                <option value="" disabled selected hidden>{{ $servicePlaceholder ?? 'Elige tu servicio' }}</option>
                <option value="internet">Internet Fibra</option>
                <option value="movil">Móvil</option>
            </select>
        </div>

    @endif

    @if($showServices || $modalForm)
        <p class="form-simple_description">
            ¡Déjanos tus datos y te ofrecemos el mejor precio!
        </p>

    @endif
    <div @if($modalForm) class="lead-modal-field lead-modal-field--phone" @endif>
        @if($modalForm)<label class="sr-only" for="{{ $id }}-phone">Número de celular</label>@endif
        <input
            id="{{ $id }}-phone"
            type="number"
            name="phone"
            class="form-control"
            placeholder="{{ $phonePlaceholder ?? '* Número de Celular' }}"
            data-rule-phone="col"
            data-test-id="input-c2c-phone"
            required
        >
    </div>
    <div @if($modalForm) class="lead-modal-field lead-modal-field--name" @endif>
        @if($modalForm)<label class="sr-only" for="{{ $id }}-name">Nombres y apellidos</label>@endif
        <input
            id="{{ $id }}-name"
            type="text"
            name="name"
            class="form-control"
            placeholder="{{ $namePlaceholder ?? '* Nombres y Apellidos' }}"
            data-test-id="input-c2c-name"
            required
        >
    </div>

    <div class="form-simple_tyc">
        <label class="text-xxs">
            <input type="checkbox" name="legal" id="{{ $id }}-legal" required>
            <span>
                Acepto
                <a
                    href="#"
                    data-toggle="modal"
                    data-target="#modal-text"
                    data-content="{{url('/privacy')}}"
                    data-modal-title="Políticas de privacidad"
                    title="Política de privacidad"
                >
                    política de privacidad,
                </a>
                tratamiento de
                <a
                    href="#"
                    data-toggle="modal"
                    data-target="#modal-text"
                    data-content="{{url('/privacy')}}"
                    data-modal-title="Políticas de privacidad"
                    title="Política de privacidad"
                >
                    datos personales y envío de mensajes vía WhatsApp.
                </a>
            </span>
        </label>
        <label for="{{ $modalForm ? $id.'-legal' : 'legal' }}" class="error d-block"></label>
    </div>

    <button
        id="btn-submit-{{ $id }}-form"
        class="form-control btn-form"
        data-c2c="TE LLAMAMOS"
        type="submit"
    >
        <div class="btn-form_content">
            {{ $submitText ?? 'Llámame' }}
        </div>
        <span class="btn-form_loader">
            <span class="loader"></span>
        </span>
    </button>
</form>
