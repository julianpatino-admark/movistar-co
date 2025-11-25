<?php

namespace App\DTOs;

class OfferData {
    /**
     * @param ServiceData[] $services
     */
    public function __construct(
        public string|int $speed,
        public int $price,
        public ?int $discount = null,
        public ?string $customBadgeLabel = null,

        // Nuevas Propiedades
        public string $title = 'Internet',
        public bool $isRecommended = false,
        public bool $hasPromo = true,
        public array $services = [],
        public array $packages = [],

        public ?string $priceNote = null,   // El texto "x 12 Meses."

        public string $speedUnit = 'Mbps',
        public ?string $speedSubtitle = null,

        public string $layout = 'standard',


    ){}

    public function getDiscountPrice(): float
    {
        $dcto = $this->discount ?? 0;
        return $this->price * (1 - ($dcto / 100));
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->price, 0, ',', '.');
    }

    public function getFormattedDiscountPrice(): string
    {
        return number_format($this->getDiscountPrice(), 0, ',', '.');
    }

    public function getBadgeLabel(): ?string
    {
        if($this->customBadgeLabel) {
            return $this->customBadgeLabel;
        }

        if ($this->discount) {
            return "{$this->discount}% Dto. Exclusivo Online";
        }

        return null;
    }
}