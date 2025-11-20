<?php

namespace App\DTOs;

readonly class ServiceData
{
    public function __construct(
        public string $icon,
        public string $text,
        public int $width = 26,
        public int $height = 26,
    ) {}
}