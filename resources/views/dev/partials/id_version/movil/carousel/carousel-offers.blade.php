<div class="carousel-wrapper ">
	<div class="container">
		<h2 class="title-section text-center mb-2">Conoce más de los Planes Movistar Pospago</h2>
		<h3 class="subtitle-section text-center mb-3">Escoge un plan para tus necesidades</h3>

		<div id="offersCarousel" class="carousel-content carousel slide" data-ride="carousel" data-touch="true">

			<div class="carousel-inner always-carousel">
				<div class="carousel-item">
					<!-- card --->
					@include('dev.partials.id_version.movil.carousel.offers.offer-custom')
				</div>
				<div class="carousel-item">
					<!-- card --->
					@include('dev.partials.id_version.movil.carousel.offers.offer-four')
				</div>
				<div class="carousel-item">
					<!-- card--->
					@include('dev.partials.id_version.movil.carousel.offers.offer-one')
				</div>
				<div class="carousel-item">
					<!-- card --->
					@include('dev.partials.id_version.movil.carousel.offers.offer-two')
				</div>
				<div class="carousel-item active">
					<!-- card --->
					@include('dev.partials.id_version.movil.carousel.offers.offer-three')
				</div>
			</div>

			<div class="carousel-indicators">
				<button data-target="#offersCarousel" aria-label="offers carousel 0" data-slide-to="0"
				        class="carousel-indicators_btn"></button>
				<button data-target="#offersCarousel" aria-label="offers carousel 1" data-slide-to="1"
				        class="carousel-indicators_btn"></button>
				<button data-target="#offersCarousel" aria-label="offers carousel 2" data-slide-to="2"
				        class="carousel-indicators_btn"></button>
				<button data-target="#offersCarousel" aria-label="offers carousel 3" data-slide-to="3"
				        class="carousel-indicators_btn "></button>
				<button data-target="#offersCarousel" aria-label="offers carousel 4" data-slide-to="4"
				        class="carousel-indicators_btn "></button>
			</div>

			<button class="carousel-control carousel-control-prev" type="button" data-scroll-x="#offersCarousel" data-slide="prev">
				@include('dev.partials.components.icons.triangle-right')
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="carousel-control carousel-control-next" type="button" data-scroll-x="#offersCarousel" data-slide="next">
				@include('dev.partials.components.icons.triangle-right')
				<span class="visually-hidden">Next</span>
			</button>

			<div class="shadow-container"></div>
		</div>

		<p class="terminos-condiciones">
			*Aplican términos y condiciones. Basado en el análisis realizado por Ookla de los datos de SpeedTest Intelligence® para el segundo y tercer trimestre de 2022. Las marcas registradas de Ookla se usan bajo licencia y se reimprimen con permiso.
		</p>
	</div>
</div>






