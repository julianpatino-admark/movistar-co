@php
	$price = 51990;
	$discount = 50;
	$distountPrice = ($price * (1 - $discount / 100));
	$pFormatted = number_format($price, 0, ',', '.');
	$dpFormatted = number_format($distountPrice, 0, ',', '.');
@endphp

<div class="card-offer">

	<div class="card-offer_wrapper">

		<div class="card-offer_header header-movil">
			<p class="title">Contrata hoy y paga el próximo mes</p>
			<h3 class="main-title mb-0">75 GB</h3>
			<h6 class="subtitle">100 GB si tienes internet hogar movistar</h6>
		</div>

		<div class="card-offer_body">

			<div class="body-title">
				<div class="body-title_container">
					<div class="discount">50%dcto</div>
					<div class="months">meses 2 y 3</div>
				</div>
			</div>

			<div class="card-offer_price">
				<p class="card-offer_price-number">
					${{ $dpFormatted }}
				</p>
				<p class="card-offer_price-text">
					Normal ${{ $pFormatted }}
				</p>
			</div>


			<div class="card-offer_cta">
				<a
					class="btn-flex btn-accent"
					data-c2c="MOVIL 80 Gb"
					data-toggle="modal"
					data-modal-title="80 Gb"
					data-target="#modal-velocidades"
					data-tag-page="/modal/offer-3-mobile/c2c"
					data-show-element="#modal-header-phone"
				>
					LO QUIERO
				</a>
			</div>

		</div>

		<div class="card-offer_footer">
			<div class="package-item">
				<div>
					@include("vendor.partials.components.icons.menu.movil")
				</div>
				<div>
					<h4>Minutos ilimitados</h4>
					<p>USA, CANADA, PUERTO RICO</p>
				</div>
			</div>

			<div class="package-item">
				<div>
					@include("vendor.partials.components.icons.cards.movistar")
				</div>
				<div>
					<h4>Después navegas <br> Sin Fin a 2 mbps</h4>
				</div>
			</div>
		</div>
	</div>
</div>
