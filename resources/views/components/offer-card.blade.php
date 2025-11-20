@props(['offer', 'offerNumber'])

<div class="card-offer">

	@if($offer->isRecommended)
		<div class="card-offer_title">
			Plan Recomendado
		</div>
	@endif

	<div class="card-offer_wrapper">

		<div class="card-offer_header">
			<h4 class="main-title">{{ $offer->title }}</h4>
			<h3 class="main-speed">
				<b>{{ $offer->speed }}</b> Mbps
			</h3>
		</div>
		<div class="card-offer_discount">
			<img width="13" height="13" src="{{ asset('img/common/icon-descuento.webp') }}" alt="Icono de descuento" />
			<p class="months">{{ $offer->discount }}% Dto. Exclusivo Online</p>
		</div>
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
					Normal ${{ $offer->getFormattedPrice() }}
				</p>
			</div>

			@foreach($offer->services as $service)
                <div class="card-offer_services">
                    <img
						width="{{ $service->width }}"
						height="{{ $service->height }}"
						src="{{ asset($service->icon) }}"
						alt="Logo servicio"
					>
                    <p>{!! $service->text !!}</p>
                </div>
            @endforeach
		</div>

		<div class="card-offer_footer">
			<button
				class="btn-flex btn-carousel"
				data-c2c="FIBRA {{ $offer->speed }} MB COMBO PLUS"
				data-toggle="modal"
				data-modal-title="{{ $offer->speed }} Mb"
				data-target="#modal-velocidades"
				data-tag-page="/modal/offer-{{ $offerNumber }}-fibra/c2c"
				data-show-element="#modal-header-phone"
			>
				LO QUIERO
			</button>
		</div>
	</div>
</div>