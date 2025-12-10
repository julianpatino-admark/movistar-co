<?php
    $startFrom = $startFrom ?? 0;
?>

<div id="carouselBanner" class="splide" data-start-on="<?php echo e($startFrom); ?>">
    <div class="splide__track">
        <div class="splide__list">
            <div class="splide__slide">
                <?php echo $__env->make('dev.partials.id_version.generica.main-banner.sld-1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="splide__slide">
                <?php echo $__env->make('dev.partials.id_version.generica.main-banner.sld-2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>

        <ul class="splide__pagination"></ul>
    </div>
</div>
<?php /**PATH /home/konecta/htdocs/movistar/resources/views/dev/partials/id_version/generica/main-banner.blade.php ENDPATH**/ ?>