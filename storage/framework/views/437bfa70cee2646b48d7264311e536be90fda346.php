<div id="modal-manual" class="modal modal-brand modal-text fade" tabindex="-1" role="dialog" data-show="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"  data-dismiss="modal" aria-label="Close">&times;</button>
				<h5 class="modal_title"></h5>
			</div>
			<div class="modal-body">
				<div class="modal_content modal-scrollable preserve-text">
					<?php echo $__env->make('partials.layouts.texts.tratamiento-datos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
			</div>
		</div>
	</div>
</div><?php /**PATH /home/konecta/htdocs/movistar/resources/views/partials/layouts/modal/manual.blade.php ENDPATH**/ ?>