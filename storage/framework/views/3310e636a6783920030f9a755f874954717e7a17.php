<?php $__env->startSection('metadata'); ?>
	<title>Movistar Co | Gracias por tu registro</title>
	<!-- inject-style src="../../css/purged/generica.css" -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/generica.scss']); ?>

	<link rel="shortcut icon" type="image/svg" href="<?php echo e(asset('/img/common/favicon.svg')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('partials.layouts.gracias.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('partials.layouts.extend.master',[
    'nav' => false,
    'header_phone' => false,
    'main_c2c' => false,
    'footer_form' => false,
    'main_cta_mobile' => false,
    'header_relative' => true
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/konecta/htdocs/movistar/resources/views/vendor/tracking/gracias/index.blade.php ENDPATH**/ ?>