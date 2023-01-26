<div class="promo-cards poker">
    <div class="promo-cards_discount">
        <div class="promo-cards_discount-number">{{ $discount }}%</div>
        de dto
    </div>
    <div class="promo-cards_offert">
        <div class="promo-cards_offert-speed">
            {{ $slot }}
        </div>
        <div class="promo-cards_offert-price">${{ $price }}</div>
        {{ $months }}
    </div>
    <p class="promo-cards_tyc">*Aplican terminos y condiciones</p>
</div>
