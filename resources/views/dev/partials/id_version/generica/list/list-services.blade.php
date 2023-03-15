<section class="list-services">
	<div class="container">
		<div class="row">
			<div id="servicesCarousel" class="carousel-content carousel slide" data-ride="carousel" data-touch="true">

				<div class="carousel-inner">
					<div class="carousel-item active">
						<div class="list-services_item">
							<div class="list-services_icon">
								@include("vendor.partials.components.icons.cards.movistar")
							</div>
							<div class="list-services_info">
								<h3 class="info_title font-weight-bold">Internet + Elegiapps TV</h3>
								<p class="info_subtitle">Descubre cómo activar tus elegiapps TV</p>
							</div>
							<div class="list-services_cta">
								<button
									class="btn-flex btn-accent font-family-bold"
									data-c2c="INFORMACION Internet + Elegiapps"
									data-toggle="modal"
									data-target="#modal-c2c"
									aria-label="INFORMACIÓN Internet + Elegiapps"
									data-show-element="#modal-header-phone"
									data-tag-page="/modal/internet-elegiapps/c2c"
								>
									Quiero información
								</button>
							</div>
						</div>
					</div>
					<div class="carousel-item">
						<div class="list-services_item">
							<div class="list-services_icon">
								@include('dev.partials.components.icons.menu.wifi-icon')
							</div>
							<div class="list-services_info">
								<h3 class="info_title font-weight-bold">¿Solo necesitas Internet?</h3>
								<p class="info_subtitle">6MB | 10MB</p>
							</div>
							<div class="list-services_cta">
								<button
									class="btn-flex btn-accent font-family-bold"
									data-c2c="TE LLAMAMOS Solo Fibra"
									data-toggle="modal"
									data-target="#modal-c2c"
									aria-label="TE LLAMAMOS Solo Fibra"
									data-show-element="#modal-header-phone"
									data-tag-page="/modal/solo-fibra/c2c"
								>
									Quiero información
								</button>
							</div>
						</div>
					</div>
					<div class="carousel-item">
						<div class=" list-services_item">
							<div class="list-services_icon">
								@include('dev.partials.components.icons.menu.movil')
							</div>
							<div class="list-services_info">
								<h3 class="info_title font-weight-bold">Pásate a Móvil</h3>
								<p class="info_subtitle">Movistar Pospago</p>
							</div>
							<div class="list-services_cta">
								<button
									class="btn-flex btn-accent font-family-bold"
									data-c2c="INFORMACION Movil"
									data-toggle="modal"
									data-target="#modal-c2c"
									aria-label="INFORMACIÓN Movil"
									data-show-element="#modal-header-phone"
									data-tag-page="/modal/movil/c2c"
								>
									Quiero información
								</button>
							</div>
						</div>
					</div>
					<div class="carousel-item">
						<div class=" list-services_item">
							<div class="list-services_icon">
								<img class="mr-1" height="20px" width="20px" src="{{ asset('img/menu/icons-pymes-active.png') }}" alt="Icono de un ordenador de escritorio">
							</div>
							<div class="list-services_info">
								<h3 class="info_title font-weight-bold">Soluciones para tu negocio</h3>
								<p class="info_subtitle">Productividad total</p>
							</div>
							<div class="list-services_cta">
								<button
									class="btn-flex btn-accent font-family-bold"
									data-c2c="INFORMACION Empresa"
									data-toggle="modal"
									data-target="#modal-c2c"
									aria-label="INFORMACIÓN Empresa"
									data-show-element="#modal-header-phone"
									data-tag-page="/modal/empresas/c2c"
								>
									Quiero información
								</button>
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
					        class="carousel-indicators_btn "></button>
				</div>
			</div>
		</div>
	</div>
</section>

