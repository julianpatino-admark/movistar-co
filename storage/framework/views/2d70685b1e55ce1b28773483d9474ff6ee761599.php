<picture class=<?php echo e($attributes->get('class')); ?>>
    <?php echo $srcSet; ?>

    <img src="<?php echo e($routeImage); ?>" <?php echo e($attributes->filter(fn (string $value, string $key) => $key !== 'class')); ?> />
</picture>
<?php /**PATH /home/konecta/htdocs/movistar/resources/views/components/responsive-image.blade.php ENDPATH**/ ?>