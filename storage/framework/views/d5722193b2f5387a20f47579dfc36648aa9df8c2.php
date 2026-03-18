<?php
    // 1. Importamos la clase (es necesario el namespace completo)
    use App\DTOs\OfferData;
	use App\DTOs\ServiceData;

    // 2. Creamos la colección de objetos DIRECTAMENTE aquí
    $offers = collect([
		new OfferData(
			speed: 'Fibra 900 Megas',
			speedUnit: '',
			speedSubtitle: '+ Pospago ilimitado',
			customBadgeLabel: '<b>50% Dto en el mes 2. Exclusivo Online</b>',
			price: 106990,
			discount: 50,
			isRecommended: false,
			services: [
				new ServiceData(
                    icon: 'resources/img/common/velocidad-simetrica.webp',
                    text: '<b>Velocidad simétrica.</b>',
                    width: 30,
                    height: 9
				),
                new ServiceData(
                    icon: 'resources/img/common/comparte.webp',
                    text: '<b>15 GB</b> para compartir',
                    width: 21,
                    height: 22
				)
			]
		),
        new OfferData(
			speed: 'Fibra 900 Megas',
			speedUnit: '',
			speedSubtitle: 'Pospago ilimitado + App de video',
			isRecommended: true,
			customBadgeLabel: '<b>50% Dto en el mes 2. Exclusivo Online</b>',
			price: 124990,
			discount: 50,
			services: [
				new ServiceData(
                    icon: 'resources/img/common/velocidad-simetrica.webp',
                    text: '<b>Velocidad simétrica.</b>',
                    width: 30,
                    height: 9
				),
                new ServiceData(
                    icon: 'resources/img/common/comparte.webp',
                    text: '<b>15 GB</b> para compartir',
                    width: 21,
                    height: 22
				)
			],
			packages: [
				new ServiceData(
                    icon: 'resources/img/common/logo-disney-premium.webp',
                    text: 'Elige <b>¡Disney+</b>',
                    width: 56,
                    height: 38
                ),
				new ServiceData(
					icon: 'resources/img/common/logo-win-play.webp',
					text: 'tal vez <b>Win Play</b>',
					width: 52,
					height: 27
				),
				new ServiceData(
					icon: 'resources/img/common/logo-netflix.webp',
					text: 'O que tal <b>Netflix</b>',
					width: 56,
					height: 22
				)
			]
		),
    ]);
?>

<div class="carousel-wrapper">
	<div class="splide container position-relative" id="offert-carrousel-bogota-fibra">
		<h2 class="title-section">¡Internet Fibra Óptica, el más rápido de Colombia!</h2>
		<h3 class="subtitle-section">Planes de Internet Fibra óptica y línea fija, con velocidades que te dan libertad.</h3>

		<div class="navbar-container">
			<nav class="navbar-nav nav-carousel">
				<?php echo $__env->make("partials.layouts.navbar.nav-items", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</nav>
		</div>

		<?php echo $__env->make('partials.id_version.internet-movil.carousel.carousel-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<div class="splide__track">

			<div class="splide__list">
				<?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="splide__slide">
						<!-- card --->
						<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.offer-card','data' => ['offer' => $offer,'offerNumber' => $loop->iteration]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('offer-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['offer' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($offer),'offer-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loop->iteration)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
		</div>
		
		<div class="splide__arrows">
			<button class="splide__arrow splide__arrow--prev">
				<?php echo $__env->make('partials.components.icons.buttons.arrow-left', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</button>
			<button class="splide__arrow splide__arrow--next">
				<?php echo $__env->make('partials.components.icons.buttons.arrow-right', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</button>
	  	</div>

		<ul class="splide__pagination"></ul>

		<p class="terminos-condiciones">
			*Aplican términos y condiciones. Basado en el análisis realizado por Ookla de los datos de SpeedTest Intelligence® para el segundo y tercer trimestre de 2022. Las marcas registradas de Ookla se usan bajo licencia y se reimprimen con permiso.
		</p>
	</div>
</div><?php /**PATH /home/konecta/htdocs/movistar/resources/views/partials/id_version/internet-movil/carousel/fibra/carousel-offers.blade.php ENDPATH**/ ?>