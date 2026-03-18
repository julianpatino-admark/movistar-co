@php
    // 1. Importamos la clase (es necesario el namespace completo)
    use App\DTOs\OfferData;
	use App\DTOs\ServiceData;

    // 2. Creamos la colección de objetos DIRECTAMENTE aquí
    $offers = collect([
        new OfferData(
			speed: 'Fibra 900',
			speedUnit: '',
			speedSubtitle: 'megas simétricas',
			customBadgeLabel: '<b>10% Dto x 6 meses. Exclusivo Online</b>',
			price: 131990,
			discount: 10,
			services: [
				new ServiceData(
                    icon: 'resources/img/common/dos-decos.webp',
                    text: '<b>TV con 1 deco</b> incluido.',
                    width: 30,
                    height: 9
				),
                new ServiceData(
                    icon: 'resources/img/common/icono-television.webp',
                    text: '<b>Movistar TV</b> desde 71 canales HD.',
                    width: 23,
                    height: 20
				)
			]
		),
		new OfferData(
			speed: 'Fibra 900',
			speedUnit: '',
			speedSubtitle: 'megas simétricas + App de video',
			customBadgeLabel: '<b>10% Dto x 6 meses. Exclusivo Online</b>',
			price: 149990,
			discount: 10,
			isRecommended: true,
			services: [
				new ServiceData(
                    icon: 'resources/img/common/dos-decos.webp',
                    text: '<b>TV con 1 deco</b> incluido.',
                    width: 30,
                    height: 9
				),
                new ServiceData(
                    icon: 'resources/img/common/icono-television.webp',
                    text: '<b>Movistar TV</b> desde 71 canales HD.',
                    width: 23,
                    height: 20
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
@endphp

<div class="carousel-wrapper ">
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





