<div class="carousel-wrapper ">
	<div class="container">
		<h2 class="title-section">¡Internet Fibra Óptica, el más rápido de Colombia!</h2>
		<h3 class="subtitle-section">Planes de Internet Fibra óptica y línea fija, con velocidades que te dan libertad.</h3>

		@include('dev.partials.id_version.generica.carousel.carousel-navbar')

		<div id="offersCarousel" class="carousel-content carousel slide" data-ride="carousel" data-touch="true">

			<div class="carousel-inner">
				<div class="carousel-item active">
					<!-- card --->
					@include('dev.partials.id_version.generica.carousel.duo_fibra.offers.offer-one')
				</div>
				<div class="carousel-item">
					<!-- card --->
					@include('dev.partials.id_version.generica.carousel.duo_fibra.offers.offer-two')
				</div>
				<div class="carousel-item">
					<!-- card --->
					@include('dev.partials.id_version.generica.carousel.duo_fibra.offers.offer-three')
				</div>
			</div>

			<div class="carousel-indicators">
				<button data-target="#offersCarousel" aria-label="offers carousel 0" data-slide-to="0"
				        class="carousel-indicators_btn active"></button>
				<button data-target="#offersCarousel" aria-label="offers carousel 1" data-slide-to="1"
				        class="carousel-indicators_btn"></button>
				<button data-target="#offersCarousel" aria-label="offers carousel 2" data-slide-to="2"
				        class="carousel-indicators_btn "></button>
			</div>
		</div>

		<p class="terminos-condiciones">
			*Aplican términos y condiciones. Basado en el análisis realizado por Ookla de los datos de SpeedTest Intelligence® para el segundo y tercer trimestre de 2022. Las marcas registradas de Ookla se usan bajo licencia y se reimprimen con permiso.
		</p>
	</div>
</div>






