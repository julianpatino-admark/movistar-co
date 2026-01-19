<?php $__env->startSection('metadata'); ?>
	<title><?php echo e(config('app.name')); ?> - Error 404. Página no encontrada</title>
	<!-- inject-style src="../../css/purged/generica.css" -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/internet-movil.scss']); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('partials.layouts.errors.404', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('partials.layouts.extend.master',[
    'nav' => false,
    'header_phone' => true,
    'main_c2c' => false
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/konecta/htdocs/movistar/resources/views/vendor/tracking/errors/404.blade.php ENDPATH**/ ?>