@php
    // 1. Importamos la clase (es necesario el namespace completo)
    use App\DTOs\OfferData;
	use App\DTOs\ServiceData;

    // 2. Creamos la colección de objetos DIRECTAMENTE aquí
    $offers = collect([
        new OfferData(
			speed: 900,
			price: 97990,
			discount: 30,
			title: 'Internet + Telefonía fija',
			priceNote: 'x 12 Meses.',
			isRecommended: true,
			services: []
		),
        new OfferData(
			speed: 900,
			price: 110990,
			discount: 30,
			title: 'Internet + Telefonía fija',
			priceNote: 'x 12 Meses.',
			services: [
                new ServiceData(
					icon: 'resources/img/common/logo-win-play.webp',
					text: '<b>Win Play</b> actívalo en tu servicio Hogar desde la App mi Movistar',
					width: 42,
					height: 23
				)
			]
		),
		new OfferData(
			speed: 900,
			price: 108990,
			discount: 30,
			title: 'Internet + Telefonía fija',
			priceNote: 'x 12 Meses.',
			services: [
                new ServiceData(
                    icon: 'resources/img/common/logo-disney-plus.webp',
                    text: '<b>¡Disney+</b> incluido en tu plan!',
                    width: 38,
                    height: 38
                ),
			]
		),
    ]);
@endphp

<div class="carousel-wrapper">
	<div class="splide container position-relative" id="offert-carrousel-bogota-fibra">

		<h2 class="title-section">¡Internet Fibra Óptica, el más rápido de Colombia!</h2>
		<h3 class="subtitle-section">Planes de Internet Fibra óptica y línea fija, con velocidades que te dan libertad.</h3>

		<div class="navbar-container">
			<nav class="navbar-nav nav-carousel">
				@include("partials.layouts.navbar.nav-items")
			</nav>
		</div>

		@include('partials.id_version.generica.carousel.carousel-navbar')

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



