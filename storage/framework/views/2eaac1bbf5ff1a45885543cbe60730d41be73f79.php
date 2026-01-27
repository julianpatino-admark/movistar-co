<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['offer', 'offerNumber']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['offer', 'offerNumber']); ?>
<?php foreach (array_filter((['offer', 'offerNumber']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="card-offer <?php echo e($offer->layout ? $offer->layout : ''); ?>">

	<?php if($offer->isRecommended): ?>
		<div class="card-offer_title">
			Plan Recomendado
		</div>
	<?php endif; ?>

	<div class="card-offer_wrapper">

		<div class="card-offer_header">
			<h4 class="main-title"><?php echo e($offer->title); ?></h4>
			<h3 class="main-speed">
				<b><?php echo e($offer->speed); ?></b>

				<?php if($offer->speedUnit): ?>
					<?php echo e($offer->speedUnit); ?>

				<?php endif; ?>

				<?php if($offer->speedSubtitle): ?>
                    <br><i><?php echo e($offer->speedSubtitle); ?></i>
                <?php endif; ?>
			</h3>
		</div>

		<?php if($offer->getBadgeLabel()): ?>
			<div class="card-offer_discount">
				<img width="13" height="13" src="<?php echo e(Vite::asset('resources/img/common/icon-descuento.webp')); ?>" alt="Icono de descuento" />
				<p class="months"><?php echo $offer->getBadgeLabel(); ?></p>
			</div>
		<?php endif; ?>

		<div class="card-offer_body">
			<?php if($offer->hasPromo): ?>
				<div class="badge-condition">
					Contrata hoy y paga el otro mes
				</div>
			<?php endif; ?>
			<div class="card-offer_price">
				<p class="card-offer_price-number">
					<span>$</span><?php echo e($offer->getFormattedDiscountPrice()); ?>

				</p>
				<p class="card-offer_price-text">
					<?php if($offer->priceNote): ?>
                        <b><?php echo e($offer->priceNote); ?></b>
                    <?php endif; ?>
					<?php if($offer->discount > 0): ?>
						Normal $<?php echo e($offer->getFormattedPrice()); ?>

					<?php endif; ?>
				</p>
			</div>

			<?php if($offer->layout !== 'standard'): ?>
				<div class="card-offer_cta">
					<a
						class="btn-flex btn-accent"
						data-c2c="MOVIL DE <?php echo e($offer->speed); ?>"
						data-toggle="modal"
						data-modal-title="<?php echo e($offer->speed); ?>"
						data-target="#modal-velocidades"
						data-tag-page="/modal/offer-<?php echo e($offerNumber); ?>-mobile/c2c"
						data-show-element="#modal-header-phone"
					>
						LO QUIERO
					</a>
				</div>
			<?php endif; ?>

			<?php $__currentLoopData = $offer->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card-offer_services">
                    <img
						width="<?php echo e($service->width); ?>"
						height="<?php echo e($service->height); ?>"
						src="<?php echo e(Vite::asset($service->icon)); ?>"
						alt="Logo servicio"
					>
                    <p><?php echo $service->text; ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			<?php $__currentLoopData = $offer->packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="package-included">
					<p class="budget <?php echo e($package->theme ?? ''); ?>"><?php echo e($package->text); ?></p>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
		<?php if($offer->layout === 'standard'): ?>
			<div class="card-offer_footer">
				<button
					class="btn-flex btn-carousel"
					data-c2c="FIBRA <?php echo e($offer->speed); ?> MB COMBO PLUS : <?php echo e($offer->getFormattedDiscountPrice()); ?>"
					data-toggle="modal"
					data-modal-title="<?php echo e($offer->speed); ?> Mb"
					data-target="#modal-velocidades"
					data-tag-page="/modal/offer-<?php echo e($offerNumber); ?>-fibra/c2c"
					data-show-element="#modal-header-phone"
				>
					LO QUIERO
				</button>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php /**PATH /home/konecta/htdocs/movistar/resources/views/components/offer-card.blade.php ENDPATH**/ ?>