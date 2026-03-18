@php
    // 1. Importamos la clase (es necesario el namespace completo)
    use App\DTOs\OfferData;
	use App\DTOs\ServiceData;

    // 2. Creamos la colección de objetos DIRECTAMENTE aquí
    $offers = collect([
		new OfferData(
			speed: '50 GB',
			speedUnit: '',
			customBadgeLabel: '50% de dto. exclusivo online',
			discount: 50,
			price: 45990,
			priceNote: 'x2 Meses.',
			isRecommended: false,
			hasPromo: false,
			layout: 'mobile theme-green',
			services: [
                new ServiceData(
                    icon: 'resources/img/common/logo-perplexity.webp',
                    text: '<b>Perplexity Pro</b>incluido en tu plan x 12 meses.',
                    width: 28,
                    height: 28
				),
				new ServiceData(
                    icon: 'resources/img/common/vowifi.webp',
                    text: '<b>Voz Wi-Fi</b>incluido en tu plan.',
                    width: 28,
                    height: 28
				),
				new ServiceData(
                    icon: 'resources/img/common/RRSS.webp',
                    text: '<b>Redes sociales</b>incluido en tu plan.',
                    width: 28,
                    height: 28
				),
				new ServiceData(
                    icon: 'resources/img/common/share-dataplan.webp',
                    text: '<span style="font-weight:bold">15 GIGAS</span>para compartir.',
                    width: 28,
                    height: 28
				),
			]
		),
		new OfferData(
			speed: '65 GB',
			speedUnit: '',
			customBadgeLabel: '50% de dto. exclusivo online',
			discount: 50,
			price: 52990,
			priceNote: 'x4 Meses.',
			isRecommended: false,
			hasPromo: false,
			layout: 'mobile theme-green',
			services: [
                new ServiceData(
                    icon: 'resources/img/common/logo-perplexity.webp',
                    text: '<b>Perplexity Pro</b>incluido en tu plan x 12 meses.',
                    width: 28,
                    height: 28
				),
				new ServiceData(
                    icon: 'resources/img/common/vowifi.webp',
                    text: '<b>Voz Wi-Fi</b>incluido en tu plan.',
                    width: 28,
                    height: 28
				),
				new ServiceData(
                    icon: 'resources/img/common/share-dataplan.webp',
                    text: '<span style="font-weight:bold">15 GIGAS</span>para compartir.',
                    width: 28,
                    height: 28
				),
				new ServiceData(
                    icon: 'resources/img/common/messages.webp',
                    text: '<b>SMS ilimitado</b> todo destino.',
                    width: 28,
                    height: 28
				),
			]
		),
        new OfferData(
			speed: 'DATOS',
			speedUnit: '',
			speedSubtitle: 'ILIMIDATOS',
			customBadgeLabel: '',
			price: 69990,
			priceNote: 'Paga el siguiente mes',
			isRecommended: false,
			hasPromo: false,
			layout: 'mobile ilimitado expanded',
			services: [
				new ServiceData(
                    icon: 'resources/img/common/logo-perplexity.webp',
                    text: '<b>Perplexity Pro</b>incluido en tu plan x 12 meses.',
                    width: 28,
                    height: 28
				),
				new ServiceData(
                    icon: 'resources/img/common/vowifi.webp',
                    text: '<b>Voz Wi-Fi</b>incluido en tu plan.',
                    width: 28,
                    height: 28
				),
				new ServiceData(
                    icon: 'resources/img/common/share-dataplan.webp',
                    text: '<span style="font-weight:bold">15 GIGAS</span>para compartir.',
                    width: 28,
                    height: 28
				),
				new ServiceData(
                    icon: 'resources/img/common/messages.webp',
                    text: '<b>Minutos ilimitados</b> a USA, Canadá, Pto. Rico y Colombia.',
                    width: 28,
                    height: 28
				),
			]
		),
		new OfferData(
			speed: 'DATOS',
			speedUnit: '',
			speedSubtitle: 'ILIMIDATOS',
			customBadgeLabel: 'Con Roaming Internacional',
			price: 104990,
			priceNote: 'Paga el siguiente mes',
			isRecommended: false,
			hasPromo: false,
			layout: 'mobile ilimitado',
			services: [
				new ServiceData(
                    icon: 'resources/img/common/logo-perplexity.webp',
                    text: '<b>Perplexity Pro</b>incluido en tu plan x 12 meses.',
                    width: 28,
                    height: 28
				),
				new ServiceData(
                    icon: 'resources/img/common/vowifi.webp',
                    text: '<b>Voz Wi-Fi</b>incluido en tu plan.',
                    width: 28,
                    height: 28
				),
				new ServiceData(
                    icon: 'resources/img/common/share-dataplan.webp',
                    text: '<span style="font-weight:bold">25 GB para Roaming </span>de datos y 15 GB para compartir.',
                    width: 28,
                    height: 28
				),
				new ServiceData(
                    icon: 'resources/img/common/messages.webp',
                    text: '<b>Minutos ilimitados</b> a USA, Canadá, Pto. Rico y Colombia.',
                    width: 28,
                    height: 28
				),
			]
		)
    ]);
@endphp


<div class="carousel-wrapper">
	<div class="splide container position-relative" id="offer-carrousel">

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






