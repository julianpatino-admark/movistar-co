<div class="float-whatsapp" id="mainChatFloatContainer">
    <div class="form-float">
        <?php echo $__env->make('partials.components.forms.wppsimple',['id' => 'whatsapp-c2c', 'class'=>'form-whatsapp',  'showServices' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <h5 class="float-whatsapp_title">
            <img width="23" height="23" src="<?php echo e(Vite::asset('resources/img/common/logo-whatsapp-mini.png')); ?>" alt="Logo WhatsApp mini formato PNG">
            <span>Ventas por WhatsApp</span>
            <button type="button" class="btn-close" aria-label="Close"></button>
        </h5>
    </div>
    <button class="btn-float" id="wppFloatButton">
        <img width="82" height="82" src="<?php echo e(Vite::asset('resources/img/common/logo-whatsapp.svg')); ?>" alt="WhatsApp Logo en formato SVG">
    </button>
</div><?php /**PATH /home/konecta/htdocs/movistar/resources/views/partials/components/buttons/whatsapp.blade.php ENDPATH**/ ?>