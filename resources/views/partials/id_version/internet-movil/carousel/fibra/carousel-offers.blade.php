@php
    // 1. Importamos la clase (es necesario el namespace completo)
    use App\DTOs\OfferData;
	use App\DTOs\ServiceData;

    // 2. Creamos la colección de objetos DIRECTAMENTE aquí
    $offers = collect([
		new OfferData(
			title: 'Internet + Pospago',
			speed: '900 Megas +',
			speedUnit: '',
			speedSubtitle: 'Ilimitado',
			customBadgeLabel: '<b>Sin Fin</b> a máxima velocidad',
			price: 106990,
			isRecommended: true,
			services: [
				new ServiceData(
					icon: 'resources/img/common/logo-win-lite.webp',
					text: '<b>¡WIN Lite</b> incluido en tu plan!',
					width: 38,
					height: 38
				),
				new ServiceData(
                    icon: 'resources/img/common/velocidad-simetrica.webp',
                    text: 'Velocidad simétrica <b>sube y baja a la misma velocidad</b>',
                    width: 30,
                    height: 9
				),
                new ServiceData(
                    icon: 'resources/img/common/comparte.webp',
                    text: '<b>15 GB</b> para compartir',
                    width: 23,
                    height: 20
				)
			]
		),
        new OfferData(
			title: 'Internet + Pospago',
			speed: '900 Megas +',
			speedUnit: '',
			speedSubtitle: 'Ilimitado',
			customBadgeLabel: '<b>Sin Fin</b> a máxima velocidad',
			price: 114990,
			services: [
				new ServiceData(
					icon: 'resources/img/common/logo-win-play.webp',
					text: '<b>Win Play</b> actívalo en tu servicio Hogar desde la App mi Movistar',
					width: 42,
					height: 23
				),
				new ServiceData(
                    icon: 'resources/img/common/velocidad-simetrica.webp',
                    text: 'Velocidad simétrica <b>sube y baja a la misma velocidad</b>',
                    width: 30,
                    height: 9
				),
                new ServiceData(
                    icon: 'resources/img/common/comparte.webp',
                    text: '<b>15 GB</b> para compartir',
                    width: 23,
                    height: 20
				)
			]
		),
        new OfferData(
			title: 'Internet + Pospago',
			speed: '900 Megas +',
			speedUnit: '',
			speedSubtitle: 'Ilimitado',
			customBadgeLabel: '<b>Sin Fin</b> a máxima velocidad',
			price: 114990,
			services: [
				new ServiceData(
                    icon: 'resources/img/common/logo-disney-plus.webp',
                    text: '<b>¡Disney+</b> incluido en tu plan!',
                    width: 26,
                    height: 26
                ),
				new ServiceData(
                    icon: 'resources/img/common/velocidad-simetrica.webp',
                    text: 'Velocidad simétrica <b>sube y baja a la misma velocidad</b>',
                    width: 30,
                    height: 9
				),
                new ServiceData(
                    icon: 'resources/img/common/comparte.webp',
                    text: '<b>15 GB</b> para compartir',
                    width: 23,
                    height: 20
				)
			]
		),
        new OfferData(
			title: 'Internet + Pospago',
			speed: '900 Megas +',
			speedUnit: '',
			speedSubtitle: 'Ilimitado',
			isRecommended: true,
			customBadgeLabel: '<b>Sin Fin</b> a máxima velocidad',
			price: 122990,
			services: [
				new ServiceData(
                    icon: 'resources/img/common/logo-disney-plus.webp',
                    text: '<b>¡Disney+</b> incluido en tu plan!',
                    width: 26,
                    height: 26
                ),
				new ServiceData(
					icon: 'resources/img/common/logo-win-play.webp',
					text: '<b>Win Play</b> actívalo en tu servicio Hogar desde la App mi Movistar',
					width: 42,
					height: 23
				),
				new ServiceData(
                    icon: 'resources/img/common/velocidad-simetrica.webp',
                    text: 'Velocidad simétrica <b>sube y baja a la misma velocidad</b>',
                    width: 30,
                    height: 9
				),
                new ServiceData(
                    icon: 'resources/img/common/comparte.webp',
                    text: '<b>15 GB</b> para compartir',
                    width: 23,
                    height: 20
				)
			]
		),
    ]);
@endphp

<div class="carousel-wrapper">
	<div class="splide container position-relative" id="offer-carrousel">
		<h2 class="title-section">¡Internet Fibra Óptica, el más rápido de Colombia!</h2>
		<h3 class="subtitle-section">Planes de Internet Fibra óptica y línea fija, con velocidades que te dan libertad.</h3>

		<div class="navbar-container">
			<nav class="navbar-nav nav-carousel">
				@include("partials.layouts.navbar.nav-items")
			</nav>
		</div>

		@include('partials.id_version.internet-movil.carousel.carousel-navbar')

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
