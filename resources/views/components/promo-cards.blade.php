<div class="promo-cards poker">
    <div class="promo-cards_discount">
        <div class="promo-cards_discount-number">{{ $discount }}%</div>
        de dto
        <span class="promo-cards_discount-text">{{ $months }}</span>
    </div>
    <div class="promo-cards_offert">
        <div class="promo-cards_offert-speed">
            {{ $slot }}
        </div>
        <div class="promo-cards_offert-price">${{ $price }}</div>
        {{ $text }}
    </div>
</div>
