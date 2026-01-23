<?php
    // 1. Importamos la clase (es necesario el namespace completo)
    use App\DTOs\OfferData;
	use App\DTOs\ServiceData;

    // 2. Creamos la colección de objetos DIRECTAMENTE aquí
    $offers = collect([
		new OfferData(
			title: 'Pospago',
			speed: '60 GB',
			speedUnit: '',
			speedSubtitle: '85% de dto. exclusivo online',
			discount: 50,
			price: 49990,
			isRecommended: false,
			hasPromo: false,
			layout: 'mobile',
			services: [
				new ServiceData(
                    icon: 'resources/img/common/icono-regalo.webp',
                    text: '<b>Duplicamos tus Gigas</b>Aplican Términos y Condiciones',
                    width: 27, 
                    height: 31
				),
                new ServiceData(
                    icon: 'resources/img/common/logo-perplexity.webp',
                    text: '<b>Perplexity Pro</b>incluido en tu plan',
                    width: 37, 
                    height: 37
				)
			]
		),
        new OfferData(
			title: 'Pospago',
			speed: 'ILIMIDATOS',
			speedUnit: '',
			speedSubtitle: 'Exclusivo clientes WOM',
			price: 30990,
			isRecommended: false,
			hasPromo: false,
			layout: 'mobile',
			services: [
				new ServiceData(
                    icon: 'resources/img/common/logo-perplexity.webp',
                    text: '<b>Perplexity Pro</b>incluido en tu plan',
                    width: 37, 
                    height: 37
				)
			]
		),
		new OfferData(
			title: 'Pospago',
			speed: 'ILIMIDATOS',
			speedUnit: '',
			speedSubtitle: 'Con Roaming Internacional',
			price: 104990,
			isRecommended: false,
			hasPromo: false,
			layout: 'mobile',
			services: [
				new ServiceData(
                    icon: 'resources/img/common/logo-perplexity.webp',
                    text: '<b>Perplexity Pro</b>incluido en tu plan',
                    width: 37, 
                    height: 37
				),
				new ServiceData(
                    icon: 'resources/img/common/icono-celular-roaming.webp',
                    text: '<b>36 Gigas para Roaming</b>de datos y para compartir',
                    width: 22, 
                    height: 32
				),
				new ServiceData(
                    icon: 'resources/img/common/logo-movistar-arena.webp',
                    text: '<b>Movistar Arena Music</b>incluido en tu plan',
                    width: 37, 
                    height: 37
				)
			]
		)
    ]);
?>


<div class="carousel-wrapper">
	<div class="splide container position-relative" id="offer-carrousel">

		<h2 class="title-section text-center mb-2">Conoce más de los Planes Movistar Pospago</h2>
		<h3 class="subtitle-section text-center mb-3">Escoge un plan para tus necesidades</h3>

		<div class="navbar-container">
			<nav class="navbar-nav nav-carousel">
				<?php echo $__env->make("partials.layouts.navbar.nav-items", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</nav>
		</div>

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
</div>






<?php /**PATH /home/konecta/htdocs/movistar/resources/views/partials/id_version/movil/carousel/carousel-offers.blade.php ENDPATH**/ ?>