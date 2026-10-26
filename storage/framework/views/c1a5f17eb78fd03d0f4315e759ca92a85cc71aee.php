<section class="banner-simple">
	<div class="banner-simple_container container">
		<div class="banner-simple_info">
			<div class="banner-simple_info-text">
				<p class="text-title">¿No decides que plan contratar?</p>
				<p class="text-subtitle">
					<span>Te asesoramos</span><span> sobre lo que necesitas</span>
				</p>
				<div class="text-cta">
					<button
						class="btn-flex special btn-accent-d font-family-bold"
						data-c2c="AYUDA ELEGIR"
						data-toggle="modal"
						data-target="#modal-c2c"
						data-show-element="#modal-header-phone"
						data-tag-page="/modal/ayuda/c2c"
					>
						¡Ayúdenme a elegir!
					</button>
				</div>
			</div>
			<div class="banner-simple_info-image">
				<?php if (isset($component)) { $__componentOriginal917bf78d62fc9337c1e3f9917fd29205c63ff302 = $component; } ?>
<?php $component = App\View\Components\ResponsiveImage::resolve(['name' => 'services','breakpoints' => 'lg','sizes' => '380;342','path' => 'resources/img/banners'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('responsive-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\ResponsiveImage::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['width' => '265','height' => '250','alt' => 'Asesora de servicio al cliente sonriendo']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal917bf78d62fc9337c1e3f9917fd29205c63ff302)): ?>
<?php $component = $__componentOriginal917bf78d62fc9337c1e3f9917fd29205c63ff302; ?>
<?php unset($__componentOriginal917bf78d62fc9337c1e3f9917fd29205c63ff302); ?>
<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php /**PATH /home/julianjp/htdocs/movistar/resources/views/partials/layouts/banners/banner-simple.blade.php ENDPATH**/ ?>