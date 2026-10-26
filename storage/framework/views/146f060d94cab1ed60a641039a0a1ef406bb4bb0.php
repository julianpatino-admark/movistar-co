<?php
	$c2c_class = $c2c_class ?? "";
?>

<div class="container main-c2c_container <?php echo e($c2c_class); ?>">
	<div class="main-c2c_wrapper">
		<div class="main-c2c box-shadow-sm">
			<p class="main-c2c_title">
				¿Deseas comprar uno de nuestros planes?
			</p>
			<?php echo $__env->make('partials.components.forms.simple', ['id' => 'c2c-main', 'class' => 'form-simple'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
	</div>
</div>
<?php /**PATH /home/julianjp/htdocs/movistar/resources/views/partials/layouts/c2c/main.blade.php ENDPATH**/ ?>