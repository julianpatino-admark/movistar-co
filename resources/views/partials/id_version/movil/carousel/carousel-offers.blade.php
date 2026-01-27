@php
    // 1. Importamos la clase (es necesario el namespace completo)
    use App\DTOs\OfferData;
	use App\DTOs\ServiceData;

    // 2. Creamos la colección de objetos DIRECTAMENTE aquí
    $offers = collect([
		new OfferData(
			title: 'Pospago',
			speed: '60 GB',
			speedUnit: '',
			priceNote: 'x2 Meses.',
			customBadgeLabel: '50% de dto. exclusivo online',
			discount: 50,
			price: 49990,
			isRecommended: false,
			hasPromo: false,
			layout: 'mobile theme-green',
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
			customBadgeLabel: 'Exclusivo clientes WOM',
			price: 30990,
			isRecommended: false,
			hasPromo: false,
			layout: 'mobile theme-purple ilimitado',
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
			customBadgeLabel: 'Con Roaming Internacional',
			price: 104990,
			isRecommended: false,
			hasPromo: false,
			layout: 'mobile ilimitado',
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
@endphp


<div class="carousel-wrapper">
	<div class="splide container position-relative" id="offert-carrousel-fibra">

		<h2 class="title-section text-center mb-2">Conoce más de los Planes Movistar Pospago</h2>
		<h3 class="subtitle-section text-center mb-3">Escoge un plan para tus necesidades</h3>

		<div class="navbar-container">
			<nav class="navbar-nav nav-carousel">
				@include("partials.layouts.navbar.nav-items")
			</nav>
		</div>

		<div class="splide__track">

			<div class="splide__list">
				@foreach ($offers as $offer)
					<div class="splide__slide">
						<!-- card --->
						<x-offer-card
							:offer="$offer"
							:offer-number="$loop->iteration"
						/>
					</div>
				@endforeach
			</div>
		</div>

		<div class="splide__arrows">
			<button class="splide__arrow splide__arrow--prev">
				@include('partials.components.icons.buttons.arrow-left')
			</button>
			<button class="splide__arrow splide__arrow--next">
				@include('partials.components.icons.buttons.arrow-right')
			</button>
		</div>
		<ul class="splide__pagination"></ul>

		<p class="terminos-condiciones">
			*Aplican términos y condiciones. Basado en el análisis realizado por Ookla de los datos de SpeedTest Intelligence® para el segundo y tercer trimestre de 2022. Las marcas registradas de Ookla se usan bajo licencia y se reimprimen con permiso.
		</p>
	</div>
</div>






