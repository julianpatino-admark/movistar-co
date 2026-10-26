<?php
	$keyword = (app('request')->get('keyword') !== null)?app('request')->get('keyword'):'';
    $keyword = (app('request')->get('mod') !== null)?app('request')->get('mod'):$keyword;
?>



<?php $__env->startSection('metadata'); ?>
	<meta name="keywords" content="MOVISTAR Internet Hogar"/>
	<meta name="description" content="Planes de internet hogar con FIBRA ÓPTICA, telefonía y tv con hasta el 20% de descuento por 12 meses ¡Pásate ya a Movistar!" />
	<?php echo app('Illuminate\Foundation\Vite')(['resources/sass/internet-movil.scss', 'resources/js/generica.js']); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
	Movistar Co | Planes de internet y telefonía para el hogar
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('partials.id_version.internet-movil.main-banner', [ 'startFrom' => 1 ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('partials.id_version.internet-movil.carousel.carousel-offers', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('partials.layouts.banners.banner-simple', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('partials.id_version.generica.list.list-services', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('partials.layouts.conditions.collapse', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('partials.layouts.extend.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/julianjp/htdocs/movistar/resources/views/vendor/tracking/index.blade.php ENDPATH**/ ?>