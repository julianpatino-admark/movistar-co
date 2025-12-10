<div class="cta-mobile_wrapper">

	<button class="cta-mobile_btn cta-mobile_btn-calcula" data-toggle="modal" data-target="#modal-c2c" data-tag-page="/modal/calcula-mobile-fijo/c2c">
		<?php echo $__env->make('dev.partials.components.icons.buttons.toggle', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		Calcula tu precio
	</button>

	<?php if(strlen($phone) >= 9): ?>
		<a class="cta-mobile_btn cta-mobile_btn-phone goo-phone" href="tel:<?php echo e($phone); ?>"
		   data-event="phone_cta-mobile-fijo_click" title="Llama Gratis: <?php echo e($phone_formatted); ?>">
			Llámanos al<br>
			<?php echo e($phone_formatted); ?>

		</a>
	<?php endif; ?>

	<button data-toggle="modal" data-target="#modal-c2c" data-tag-page="/modal/cta-mobile-fijo/c2c"
	   class="cta-mobile_btn cta-mobile_btn-c2c" data-hiden-element="#modal-header-phone">
		<?php echo $__env->make('dev.partials.components.icons.cards.phone', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		Te llamamos GRATIS
	</button>

</div>
<?php /**PATH /home/konecta/htdocs/movistar/resources/views/dev/partials/layouts/cta/mobile-fixed.blade.php ENDPATH**/ ?>