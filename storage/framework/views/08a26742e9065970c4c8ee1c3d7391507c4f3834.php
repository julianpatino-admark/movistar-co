<?php
    $showServices = isset($showServices) ? $showServices : true;
    $keyword = (app('request')->get('keyword') !== null)?app('request')->get('keyword'):'';
    $keyword = (app('request')->get('mod') !== null)?app('request')->get('mod'):$keyword;
?>

<form id="<?php echo e($id); ?>-form"
      method="post"
      data-toggle="form-simple"
      class="form <?php if(isset($class)): ?><?php echo e($class); ?><?php endif; ?>"
      data-layer-page="/c2c/principal/conversion"
      action="<?php echo e(url('/api/form/send')); ?>">
    <?php echo e(csrf_field()); ?>

    <input type="hidden" name="c2c" value="LLÁMAME GRATIS">
    <input type="hidden" name="id_version" value="<?php echo e($id_version); ?>">
    <input type="hidden" name="tsource" value="<?php echo e($tsource); ?>">
    <input type="hidden" name="batch_id" value="MOVISTARCO_KDMA_C2CLN_Q12">

    <?php if($showServices): ?>
        <label
            class="form-simple_title"
            for="<?php echo e($id); ?>-selectServicios"
        >
            Escoge tus servicios
        </label>

        <div class="mb-2">
            <label class="input-group-text statusLoader d-none"> <i class="select-loader"></i></label>
            <select
                id="<?php echo e($id); ?>-selectServicios"
                name="servicios"
                class="form-select"
                required
            >
                <option selected value="" hidden>Internet Hogar Fibra</option>
                <option value="internet">Internet Fibra</option>
                <option value="movil">Móvil</option>
            </select>
        </div>

        <p class="form-simple_description">
            ¡Déjanos tus datos y te ofrecemos el mejor precio!
        </p>

    <?php endif; ?>
    <div>
        <input
            type="text"
            name="phone"
            class="form-control"
            placeholder="* Número de Celular"
            data-rule-phone="col"
            data-test-id="input-c2c-phone"
            required
        >
    </div>

    <?php if($keyword == "cobertura"): ?>
        <div>
            <input type="text" name="direccion" class="form-control mb-0" placeholder="Dirección: Cll 103 # 13-30, Bogotá">
        </div>

        <div class="form-simple_addr">
            <input type="checkbox" name="specialaddr" id="checkSpecialAddr" data-toggle="toggle-enabled" data-elements="#<?php echo e($id); ?>-inptDireccionAdicional">
            <label for="checkSpecialAddr">
                Mi dirección tiene especificaciones
            </label>
        </div>

        <div>
            <input type="text" class="form-control" id="<?php echo e($id); ?>-inptDireccionAdicional" name="direccionAdicional" placeholder="Apto 502, torre 1, piso 3, etc" disabled  required>
        </div>
    <?php endif; ?>

    <div class="form-simple_tyc">
        <input type="checkbox" name="legal" id="legal" required>
        <label for="legal" class="text-xxs">
            Acepto
            <a
                href="#"
                data-toggle="modal"
                data-target="#modal-text"
                data-content="<?php echo e(url('/privacy')); ?>"
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
                data-content="<?php echo e(url('/privacy')); ?>"
                data-modal-title="Política de Privacidad"
                title="Política de privacidad"
            >
                datos personales y envío de mensajes vía WhatsApp.
            </a>
        </label>
        <label for="legal" class="error d-block"></label>
    </div>

    <div class="mb-2">
        <button
            id="btn-submit-<?php echo e($id); ?>-form"
            class="form-control btn-form bg-degraded"
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
</form>

<?php /**PATH /home/konecta/htdocs/movistar/resources/views/dev/partials/components/forms/simple.blade.php ENDPATH**/ ?>