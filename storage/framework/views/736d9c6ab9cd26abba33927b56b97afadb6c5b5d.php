<div id="modal-legal" class="modal modal-brand modal-text fade" tabindex="-1" role="dialog" data-show="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal_title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
			</div>
			<div class="modal-body">
				<div class="modal_content">
					<?php echo $__env->make('partials.layouts.texts.aviso-legal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
				<div class="modal_loader">
					<div class="loader alt"></div>
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div><?php /**PATH /home/konecta/htdocs/movistar/resources/views/partials/layouts/modal/legal.blade.php ENDPATH**/ ?>