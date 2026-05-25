<?php $__env->startSection('metadata'); ?>
	<meta name="keywords" content="MOVISTAR Móvil"/>
	<meta name="description" content="Movistar pospago Móvil, datos y llamadas ilimitadas. Ademas de 50% de descuento en el segundo y tercer mes." />
	<?php echo app('Illuminate\Foundation\Vite')(['resources/sass/movil.scss', 'resources/js/generica.js']); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
	Movistar Co | Planes pospago móvil con llamadas ilimitadas
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('partials.id_version.generica.main-banner.sld-4', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('partials.id_version.movil.carousel.carousel-offers', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('partials.layouts.banners.banner-simple', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('partials.id_version.movil.list.list-apps', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('partials.id_version.movil.list.list-services', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('partials.layouts.conditions.collapse', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('partials.layouts.extend.master', [ 'main_c2c_class' => "no-carousel"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/konecta/htdocs/movistar/resources/views/vendor/tracking/movil/index.blade.php ENDPATH**/ ?>