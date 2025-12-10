<?php
    $showServices = isset($showServices) ? $showServices : true;
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
    <input type="hidden" name="lead_type" value="whatsapp">
    <input type="hidden" name="legal" value="on">

    <?php if($showServices): ?>
        <p class="form-simple_title">
            Escoge tus servicios
        </p>

        <div class="form-simple_services">
            <div class="form-check">
                <label class="form-check-label" for="<?php echo e($id); ?>-checkbox-internet">
                    <?php echo $__env->make('partials.components.icons.menu.wifi-icon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    Internet Fibra
                </label>
                <input
                    checked
                    name="servicios"
                    type="checkbox"
                    id="<?php echo e($id); ?>-checkbox-internet"
                    value="internet"
                >
            </div>

            <div class="form-check">
                <label class="form-check-label" for="<?php echo e($id); ?>-checkbox-movil">
                    <?php echo $__env->make('partials.components.icons.menu.movil', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    Móvil
                </label>
                <input
                    name="servicios"
                    type="checkbox"
                    id="<?php echo e($id); ?>-checkbox-movil"
                    value="movil"
                >
            </div>
        </div>

    <?php endif; ?>

    <div class="form-group">
        <label for="inputName" class="visually-hidden">Nombre completo</label>
        <input type="text" id="inputName" name="nombre" class="form-control" placeholder="Nombre">
    </div>

    <div class="form-group">
        <label for="inputPhoneNumber" class="visually-hidden">Número de Celular</label>
        <input
            id="inputPhoneNumber"
            type="text"
            name="phone"
            class="form-control"
            placeholder="Número de Celular"
            data-rule-phone="col"
            data-test-id="input-c2c-phone"
            required
        >
    </div>

    <select name="productos" class="form-control" aria-label="Productos de interes">
        <option value="" disabled selected hidden>Producto de interés</option>
        <option value="internet">Internet</option>
        <option value="movil">Móvil</option>
    </select>

    <div class="cta">
        <button
            id="btn-submit-<?php echo e($id); ?>-form"
            class="form-control btn-form bg-degraded"
            data-c2c="Inicio Chat"
        >
            <div class="btn-form_content font-family-bold">
                Iniciar Chat
            </div>
            <span class="btn-form_loader">
                <span class="loader"></span>
            </span>
        </button>
    </div>
</form>
<?php /**PATH /home/konecta/htdocs/movistar/resources/views/partials/components/forms/wppsimple.blade.php ENDPATH**/ ?>