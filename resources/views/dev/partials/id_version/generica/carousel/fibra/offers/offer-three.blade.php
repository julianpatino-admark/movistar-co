@php
	$price = 102990;
	$discount = 30;
	$distountPrice = ($price * (1 - $discount / 100));
	$pFormatted = number_format($price, 0, ',', '.');
	$dpFormatted = number_format($distountPrice, 0, ',', '.');
@endphp

<div class="card-offer">

	<div class="card-offer_wrapper">

		<div class="card-offer_header">
			<h4 class="main-title">con <b>Movistar Total</b> recibe</h4>
			<h3 class="main-speed">
				<b>900</b> Mbps
			</h3>
		</div>
		<div class="card-offer_discount">
			<img width="13" height="13" src="{{ asset('img/common/icon-descuento.webp') }}" alt="Icono de descuento" />
			<p class="months">{{ $discount }}% Dto. Exclusivo Online</p>
		</div>
		<div class="card-offer_body">
			<div class="badge-condition">
				Contrata hoy y paga el otro mes
			</div>

			<div class="card-offer_price">
				<p class="card-offer_price-number">
					<span>$</span>{{ $dpFormatted }}
				</p>
				<p class="card-offer_price-text">
					<b>x 12 Meses.</b> Normal ${{ $pFormatted }}
				</p>
			</div>

			<div class="card-offer_services">
				<img width="42" height="23" src="{{ asset('img/common/logo-win-play.webp') }}" alt="Logo de Win Play">
				<p><b>Win Play</b> incluido a través de Movistar Tv App</p>
			</div>
		</div>

		<div class="card-offer_footer">
			<button
				class="btn-flex btn-carousel"
				data-c2c="FIBRA 900 MB COMBO PLUS"
				data-toggle="modal"
				data-modal-title="900 Mb"
				data-target="#modal-velocidades"
				data-tag-page="/modal/offer-3-fibra/c2c"
				data-show-element="#modal-header-phone"
			>
				LO QUIERO
			</button>
		</div>
	</div>
</div>
