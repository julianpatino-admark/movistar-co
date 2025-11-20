<?php

namespace App\DTOs;

readonly class OfferData {
    /**
     * @param ServiceData[] $services
     */
    public function __construct(
        public int $speed,
        public int $price,
        public int $discount,

        // Nuevas Propiedades
        public string $title = 'Internet',
        public bool $isRecommended = false,
        public bool $hasPromo = true,
        public array $services = [],

        public ?string $priceNote = null,   // El texto "x 12 Meses."
    ){}

    public function getDiscountPrice(): float
    {
        return $this->price * (1 - ($this->discount / 100));
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->price, 0, ',', '.');
    }

    public function getFormattedDiscountPrice(): string
    {
        return number_format($this->getDiscountPrice(), 0, ',', '.');
    }
}