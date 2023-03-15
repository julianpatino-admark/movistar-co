<section class="list-apps">
	<div class="container">
		<div class="row">
			<h2 class="title-section">Beneficios exclusivos clientes Fibra Movistar</h2>

			<div id="servicesCarousel" class="carousel-content carousel slide" data-ride="carousel" data-touch="true">

				<div class="carousel-inner">
					<div class="carousel-item active">
						<div class="list-apps_item">
							<div class="list-apps_images">
								@include("vendor.partials.id_version.negocios.list.icons.simetrica")
							</div>
							<div class="list-apps_info">
								<h4 class="info_title">Velocidad Símetrica</h4>
								<p class="info_subtitle">Sube y baja a la misma velocidad</p>
							</div>
						</div>
					</div>
					<div class="carousel-item">
						<div class="list-apps_item">
							<div class="list-apps_images">
								@include("vendor.partials.id_version.negocios.list.icons.quality")
							</div>
							<div class="list-apps_info">
								<h4 class="info_title">Mayor Calidad</h4>
								<p class="info_subtitle">Más estabilidad en conexión</p>
							</div>
						</div>
					</div>
					<div class="carousel-item">
						<div class="list-apps_item">
							<div class="list-apps_images">
								<img width="54" height="54" src="{{ asset('img/common/service-computer-icon.png') }}" alt="Icono de un ordenador de escritorio con fondo azul">
							</div>
							<div class="list-apps_info">
								<h4 class="info_title">Tu Web Movistar</h4>
								<p class="info_subtitle">La manera más sencilla y personalizada para crear tu sitio web</p>
							</div>
						</div>
					</div>
					<div class="carousel-item">
						<div class="list-apps_item">
							<div class="list-apps_images">
								@include("vendor.partials.id_version.negocios.list.icons.larga-distancia")
							</div>
							<div class="list-apps_info">
								<h4 class="info_title">Larga Distancia</h4>
								<p class="info_subtitle">Nacional ilimitada, habla ilimitadamente entre fijos a niven nacional</p>
							</div>
						</div>
					</div>
				</div>

				<div class="carousel-indicators">
					<button data-target="#servicesCarousel" aria-label="offers carousel 0" data-slide-to="0"
					        class="carousel-indicators_btn active"></button>
					<button data-target="#servicesCarousel" aria-label="offers carousel 1" data-slide-to="1"
					        class="carousel-indicators_btn"></button>
					<button data-target="#servicesCarousel" aria-label="offers carousel 2" data-slide-to="2"
					        class="carousel-indicators_btn"></button>
					<button data-target="#servicesCarousel" aria-label="offers carousel 3" data-slide-to="3"
					        class="carousel-indicators_btn"></button>
				</div>
			</div>
		</div>
	</div>
</section>

