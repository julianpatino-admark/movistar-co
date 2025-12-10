<div id="modal-c2c" class="modal modal-brand modal-c2c fade" tabindex="-1" role="dialog" data-show="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="brands">
					<?php echo $__env->make('partials.components.icons.logo.brand-logo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					<img class="digital-partner-image" height="70" width="126" src="<?php echo e(Vite::asset('resources/img/common/partner-aliado-movistar.svg')); ?>" alt="Etiqueta de aliado digital Movistar" />
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
				</div>
			</div>
			<div class="modal-body">
				<div class="modal-c2c_title">
					<p>Déjanos tu número y nos pondremos en contacto contigo</p>
					<p>Te llamamos GRATIS</p>
				</div>
				<div class="modal-c2c_form">
					<?php echo $__env->make('partials.components.forms.simple',['id' => 'modal-c2c', 'class' => 'form-simple'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div><?php /**PATH /home/konecta/htdocs/movistar/resources/views/partials/layouts/modal/c2c.blade.php ENDPATH**/ ?>