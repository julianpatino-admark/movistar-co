@php
    use App\DTOs\OfferData;
	use App\DTOs\ServiceData;

    $offers = collect([
		new OfferData(
			speed: 'Fibra 500 Megas',
			speedUnit: '',
			speedSubtitle: '+ Pospago ilimitado',
			customBadgeLabel: '<b>Dto x 12 meses. Exclusivo Online</b>',
			price: 119900,
			discount: 24.946,
			isRecommended: false,
			packagesNotes: '<b>Disney</b> incluido en tu plan x 12 meses',
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
			]
		),
		new OfferData(
			speed: 'Fibra 500 Megas +',
			speedUnit: '',
			speedSubtitle: '+ TV + Pospago ilimitado',
			customBadgeLabel: '<b>Dto x 12 meses. Exclusivo Online</b>',
			price: 149900,
			discount: 19.953,
			isRecommended: true,
			packagesNotes: 'Incluido en tu plan x 12 meses',
			services: [
				new ServiceData(
                    icon: 'resources/img/common/dos-decos.webp',
                    text: '<b>TV con 2 decos</b> incluidos.',
                    width: 30,
                    height: 9
				),
                new ServiceData(
                    icon: 'resources/img/common/icono-television.webp',
                    text: '<b>Movistar TV</b> desde 90 canales HD.',
                    width: 23,
                    height: 20
				)
			],
			packages: [
				new ServiceData(
					icon: 'resources/img/common/logo-win-futbol.webp',
					text: 'tal vez <b>Win Play</b>',
					width: 66,
					height: 32
				)
			]
		)
    ]);
@endphp

<div class="carousel-wrapper">
	<div class="splide container position-relative" id="offert-carrousel-bogota-fibra">
		<h2 class="title-section">¡Internet Fibra Óptica, el más rápido de Colombia!</h2>
		<h3 class="subtitle-section">Planes de Internet Fibra óptica con velocidades que te dan libertad.</h3>

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