@props(['offer', 'offerNumber', 'c2cLabel' => null, 'tagPage' => null, 'modalTitle' => null, 'recommendedIcon' => null, 'recommendedIconMobile' => null, 'ctaText' => 'LO QUIERO', 'recommendedLabel' => 'Plan Recomendado'])

<div class="card-offer {{ $offer->layout ? $offer->layout : '' }}">

	@if($offer->isRecommended)
		<div class="card-offer_title">
			@if($recommendedIcon)
                @if($recommendedIconMobile)
                    <picture>
                        <source media="(min-width: 480px)" srcset="{{ Vite::asset($recommendedIcon) }}">
                        <img src="{{ Vite::asset($recommendedIconMobile) }}" alt="">
                    </picture>
                @else
                    <img src="{{ Vite::asset($recommendedIcon) }}" alt="">
                @endif
            @endif
			{{ $recommendedLabel }}
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
				<p class="months">{!! $offer->getBadgeLabel() !!}</p>
			</div>
		@endif

		<div class="card-offer_body">
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


				<div class="card-offer_cta">
					<button type="button"
						class="btn-flex btn-accent-b"
						data-c2c="{{ $c2cLabel ?? 'MOVIL DE '.$offer->speed }}"
						data-toggle="modal"
						data-modal-title="{{ $modalTitle ?? $offer->speed }}"
						data-target="#modal-velocidades"
						data-tag-page="{{ $tagPage ?? '/modal/offer-'.$offerNumber.'-mobile/c2c' }}"

					>
						{{ $ctaText }}
					</button>
				</div>

			<div class="services-list">
				@foreach($offer->services as $service)
					<div class="card-offer_services">
                        @include('partials.components.offer-service-icon')
						<p>{!! $service->text !!}</p>
					</div>
				@endforeach
                @if (!empty($offer->packages))
                    <div class="card-offer_services packages {{ count($offer->packages) > 1 ? 'packages--multiple' : '' }}">
                        @foreach ($offer->packages as $package)
                            @if(!$loop->first)
                                <picture class="packages__separator" aria-hidden="true">
                                    <source media="(min-width: 1200px)" srcset="{{ Vite::asset('resources/img/internet-movil/redesign/card-dot-desktop.svg') }}">
                                    <img src="{{ Vite::asset('resources/img/internet-movil/redesign/card-dot-mobile.svg') }}" alt="">
                                </picture>
                            @endif
                            <figure class="packages__item">
                                @include('partials.components.offer-service-icon', ['service' => $package])
                                <figcaption>{{ $package->text }}</figcaption>
                            </figure>
                        @endforeach
                        @if ($offer->packagesNotes)
                            <div class="package-notes">{!! $offer->packagesNotes !!}</div>
                        @endif
                    </div>
                @endif
			</div>
		</div>
	</div>
</div>
