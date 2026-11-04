@php
    use App\DTOs\OfferData;
	use App\DTOs\ServiceData;

    $offers = collect([
		new OfferData(
			speed: 'Fibra 900',
			speedUnit: '',
			speedSubtitle: 'megas simétricas',
			price: 62826,
			services: []
		),
		new OfferData(
			speed: 'Fibra 900',
			speedUnit: '',
			isRecommended: true,
			speedSubtitle: 'megas simétricas + TV',
			customBadgeLabel: '<b>50% dto x 1 mes. Exclusivo Online</b>',
			price: 114900,
			discount: 50,
			services: [
				new ServiceData(
                    icon: '/img/common/dos-decos.webp',
                    text: '<b>TV con 1 deco</b> incluido.',
                    width: 30,
                    height: 9
				),
                new ServiceData(
                    icon: '/img/common/icono-television.webp',
                    text: '<b>Movistar TV</b> desde 73 canales HD.',
                    width: 23,
                    height: 20
				)
			]
		)
    ]);
@endphp

<div class="carousel-wrapper">
	<div class="splide container position-relative" id="offert-carrousel-bogota-fibra">

		<h2 class="title-section">¡Activa nuestra oferta empaquetada!</h2>
		<h3 class="subtitle-section">Planes Movistar Total + Pospago Ilimitado en una sola factura.</h3>

		<div class="navbar-container">
			<nav class="navbar-nav nav-carousel">
				@include("dev.layouts.navbar.nav-items")
			</nav>
		</div>

		<div class="splide__track">

			<div class="splide__list">
				@foreach ($offers as $offer)
					<div class="splide__slide">
						<!-- card --->
						<x-offer-card
							:offer="$offer"
							:offer-number="$loop->iteration"></x-offer-card>
					</div>
				@endforeach
			</div>
		</div>
		
		<div class="splide__arrows">
			<button class="splide__arrow splide__arrow--prev">
				@include('dev.components.icons.buttons.arrow-left')
			</button>
			<button class="splide__arrow splide__arrow--next">
				@include('dev.components.icons.buttons.arrow-right')
			</button>
	  	</div>

		<ul class="splide__pagination"></ul>

		<p class="terminos-condiciones">
			*Aplican términos y condiciones. Basado en el análisis realizado por Ookla de los datos de SpeedTest Intelligence® para el segundo y tercer trimestre de 2022. Las marcas registradas de Ookla se usan bajo licencia y se reimprimen con permiso.
		</p>
	</div>
</div>
