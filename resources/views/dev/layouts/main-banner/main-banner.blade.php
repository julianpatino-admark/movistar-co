<div class="main-banner_content container">
	<div class="main-banner_wrapper">
		<h1 class="d-none  d-md-block d-lg-block "><b>ofertas packs internet de Euskaltel</b></h1>
		<h2>La Fibra de tu zona que nunca falla</h2>
		<div class="main-banner_icon-text ">
			<p class="font-family-bold">¡AHORA!</p>
			<div class="main-banner-icon-text_wrapper">
				@include('dev.layouts.banners.icons.wi-fi')
				@include('dev.components.icons.phone')
				@include('dev.components.icons.mobile')
				@include('dev.components.icons.cards.television')
			</div>
		</div>
		<p class="main-banner_offer-text font-family-bold">
			500 MB + 30GB + Fijo + TV Replay
		</p>
		<div class="main-banner_button-content">
			<div class="main-banner_button-label-price">
				<div class="main-banner-label">
					<p>PRECIO FINAL</p>
				</div>
				<div class="main-banner-button_price">
					<p class="main-banner-button-price_number font-family-bold">19,90€</p>
					<p class="main-banner-button-price_month ">/mes</p>
				</div>
			</div>

			<div class="main-banner-button_item">
				<button class="btn-flex w-100 font-family-bold"
				        data-c2c="PROMO MAIN BANNER INTERNET" data-toggle="modal" data-target="#modal-c2c"
				        data-hiden-element="#modal-header-phone"
				        aria-label="main banner internet" data-tag-page="/modal/main-banner-internet/c2c">
					¡lo quiero!
					@include('dev.components.icons.buttons.arrow-right')
				</button>
			</div>
		</div>
		<p class="main-banner_text-month">Oferta por 6 meses</p>
	</div>
</div>
