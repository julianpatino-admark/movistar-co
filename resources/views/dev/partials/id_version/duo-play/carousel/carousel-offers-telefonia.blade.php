@php
    $path = request()->path();
@endphp

<section class="carousel-wrapper">
	<div id="offersPlayDuoCarousel" class="splide position-relative container" aria-labelledby="carousel-heading">
		<div class="carousel_title-movil">
			<div class="icons">
            	@include('dev.partials.components.icons.signal-circle')
				+
				@include('dev.partials.components.icons.phone-circle')
			</div>
            <div>
                <h2 class="title-section">Encuentra el mejor dúo en Claro</h2>
                <h3 class="subtitle-section">Disfruta de Internet y Telefonía Fija en tu hogar.</h3>
            </div>
        </div>

		<nav class="carrousel-nav">
			<ul>
				<li class="nav-item @if($path == 'hogar/duo-telefonia')active @endif">
					<a class="nav-link" href="{{secure_url('hogar/duo-telefonia').'?'.request()->getQueryString()}}">
						Internet + Telefonía
					</a>
				</li>
				<li class="nav-item @if($path == 'hogar/duo-television')active @endif">
					<a class="nav-link" href="{{secure_url('hogar/duo-television').'?'.request()->getQueryString()}}">
						Internet + ClaroTV
					</a>
				</li>
			</ul>
		</nav>

		<div class="splide__track">
			<div class="splide__list">
				<div class="splide__slide">
					<!-- card --->
					@include('dev.partials.id_version.duo-play.carousel.offers-telefonia.offer-one')
				</div>
				<div class="splide__slide">
					<!-- card --->
					@include('dev.partials.id_version.duo-play.carousel.offers-telefonia.offer-two')
				</div>
				<div class="splide__slide">
					<!-- card --->
					@include('dev.partials.id_version.duo-play.carousel.offers-telefonia.offer-three')
				</div>
                <div class="splide__slide">
					<!-- card --->
					@include('dev.partials.id_version.duo-play.carousel.offers-telefonia.offer-four')
				</div>
                <div class="splide__slide">
					<!-- card --->
					@include('dev.partials.id_version.duo-play.carousel.offers-telefonia.offer-five')
				</div>
                <div class="splide__slide">
					<!-- card --->
					@include('dev.partials.id_version.duo-play.carousel.offers-telefonia.offer-six')
				</div>
			</div>

		</div>
		<ul class="splide__pagination"></ul>

		<div class="splide__arrows">
			<button class="splide__arrow splide__arrow--prev carousel-control-btn">
				@include("dev.partials.components.icons.cards.arrow-carousel-left")
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="splide__arrow splide__arrow--next carousel-control-btn">
				@include("dev.partials.components.icons.cards.arrow-carousel-right")
				<span class="visually-hidden">Next</span>
			</button>
		</div>
	</div>
</section>

