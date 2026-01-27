@props(['offer', 'offerNumber'])

<div class="card-offer {{ $offer->layout ? $offer->layout : '' }}">

	@if($offer->isRecommended)
		<div class="card-offer_title">
			Plan Recomendado
		</div>
	@endif

	<div class="card-offer_wrapper">

		<div class="card-offer_header">
			<h4 class="main-title">{{ $offer->title }}</h4>
			<h3 class="main-speed">
				<b>{{ $offer->speed }}</b>

				@if ($offer->speedUnit)
					{{ $offer->speedUnit }}
				@endif

				@if($offer->speedSubtitle)
                    <br><i>{{ $offer->speedSubtitle }}</i>
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
						class="btn-flex btn-accent"
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

			@foreach ($offer->packages as $package)
				<div class="package-included">
					<p class="budget {{ $package->theme ?? '' }}">{{ $package->text }}</p>
				</div>
			@endforeach
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
