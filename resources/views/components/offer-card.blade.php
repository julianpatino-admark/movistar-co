@props(['offer', 'offerNumber'])

<div class="card-offer {{ $offer->layout ? $offer->layout : '' }}">

	@if($offer->isRecommended)
		<div class="card-offer_title">
			<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
				<path d="M3.41185 10.6415L6.33661 8.87733L9.26136 10.6647L8.49536 7.3221L11.0719 5.09372L7.68292 4.79196L6.33661 1.63508L4.99029 4.76874L1.60129 5.0705L4.17786 7.3221L3.41185 10.6415ZM6.33661 9.97017L2.96618 12.0054C2.86714 12.0543 2.77521 12.0741 2.69041 12.0648C2.60623 12.0549 2.52421 12.0259 2.44436 11.9776C2.36389 11.928 2.30323 11.8581 2.26238 11.7677C2.22152 11.6774 2.21781 11.5786 2.25123 11.4715L3.14816 7.65543L0.181622 5.0835C0.0980577 5.01541 0.0429671 4.93402 0.0163503 4.83931C-0.0102665 4.7446 -0.004386 4.65392 0.0339917 4.56726C0.0723695 4.4806 0.123437 4.40942 0.187193 4.35371C0.251569 4.29986 0.338228 4.26333 0.447172 4.24415L4.3617 3.90246L5.88814 0.288762C5.93024 0.186628 5.9909 0.112967 6.07013 0.06778C6.14936 0.0225933 6.23819 0 6.33661 0C6.43503 0 6.52416 0.0225933 6.60401 0.06778C6.68386 0.112967 6.74422 0.186628 6.78507 0.288762L8.31151 3.90246L12.2251 4.24415C12.3347 4.26272 12.4216 4.29955 12.486 4.35464C12.5504 4.40911 12.6018 4.47998 12.6402 4.56726C12.6779 4.65392 12.6835 4.7446 12.6569 4.83931C12.6302 4.93402 12.5752 5.01541 12.4916 5.0835L9.52505 7.65543L10.422 11.4715C10.4566 11.5774 10.4532 11.6758 10.4118 11.7668C10.3703 11.8578 10.3093 11.9277 10.2289 11.9766C10.1496 12.0262 10.0676 12.0556 9.9828 12.0648C9.89862 12.0741 9.80701 12.0543 9.70797 12.0054L6.33661 9.97017Z" fill="white"/>
			</svg>
			Plan Recomendado
		</div>
	@endif

	<div class="card-offer_wrapper">

		<div class="card-offer_header">
			<h3 class="main-speed">
				<b>{{ $offer->speed }}</b>

				@if ($offer->speedUnit)
					{{ $offer->speedUnit }}
				@endif

				@if($offer->speedSubtitle)
                    <i>{{ $offer->speedSubtitle }}</i>
                @endif
			</h3>
		</div>

		@if($offer->getBadgeLabel())
			<div class="card-offer_discount">
				<img width="13" height="13" src="{{ Vite::asset('resources/img/common/icon-descuento.webp') }}" alt="Icono de descuento" />
				<p class="months">{!! $offer->getBadgeLabel() !!}</p>
			</div>
		@endif

		<div class="card-offer_body">
			@if($offer->hasPromo)
				<div class="badge-condition">
					Contrata hoy y paga el otro mes
				</div>
			@endif
			<div class="card-offer_price">
				<p class="card-offer_price-number">
					<span>$</span>{{ $offer->getFormattedDiscountPrice() }}
				</p>
				<p class="card-offer_price-text">
					@if($offer->priceNote)
                        <b>{{ $offer->priceNote }}</b>
                    @endif
					@if ($offer->discount > 0)
						Normal ${{ $offer->getFormattedPrice() }}
					@endif
				</p>
			</div>

			@if ($offer->layout !== 'standard')
				<div class="card-offer_cta">
					<a
						class="btn-flex btn-accent-b"
						data-c2c="MOVIL DE {{ $offer->speed }}"
						data-toggle="modal"
						data-modal-title="{{ $offer->speed }}"
						data-target="#modal-velocidades"
						data-tag-page="/modal/offer-{{ $offerNumber }}-mobile/c2c"
						data-show-element="#modal-header-phone"
					>
						LO QUIERO
					</a>
				</div>
			@endif

			<div class="services-list">
				@foreach($offer->services as $service)
					<div class="card-offer_services">
						<img
							width="{{ $service->width }}"
							height="{{ $service->height }}"
							src="{{ Vite::asset($service->icon) }}"
							alt="Logo servicio"
						>
						<p>{!! $service->text !!}</p>
					</div>
				@endforeach
			</div>

			@if (!empty($offer->packages))
				<div class="packages-list">
					<p>Selecciona tu plataforma digital*</p>

					@foreach ($offer->packages as $package)
						<div class="package-included">
							<img
								width="21"
								height="21"
								class="icon"
								src="{{ Vite::asset('resources/img/common/icon-ott-checked.webp') }}"
								alt="Icono de checked"
							>
							<img
								width="{{ $package->width }}"
								height="{{ $package->height }}"
								src="{{ Vite::asset($package->icon) }}"
								alt="Ott incluida"
							>
						</div>
					@endforeach

					<p class="error-message"></p>
				</div>
			@endif
		</div>
		@if ($offer->layout === 'standard')
			<div class="card-offer_footer">
				<button
					class="btn-flex btn-carousel"
					data-c2c="FIBRA {{ $offer->speed }} MB COMBO PLUS : {{ $offer->getFormattedDiscountPrice() }}"
					data-toggle="modal"
					data-modal-title="{{ $offer->speed }} Mb"
					data-target="#modal-velocidades"
					data-tag-page="/modal/offer-{{ $offerNumber }}-fibra/c2c"
					data-show-element="#modal-header-phone"
				>
					LO QUIERO
				</button>
			</div>
		@endif
	</div>
</div>
