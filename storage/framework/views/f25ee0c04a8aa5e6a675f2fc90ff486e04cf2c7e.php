<?php $__env->startSection('metadata'); ?>
	<title>Movistar Co | Politica de privacidad</title>
	<?php echo app('Illuminate\Foundation\Vite')(['resources/sass/generica.scss']); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="main_wrapper pt-4 pb-3">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-8">
					<div class="modal_content-data">
						<?php echo $__env->make('partials.layouts.texts.privacy', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('partials.layouts.extend.master',[
    'nav' => false,
    'header_phone' => false,
    'main_c2c' => false
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/konecta/htdocs/movistar/resources/views/vendor/tracking/privacy/index.blade.php ENDPATH**/ ?>