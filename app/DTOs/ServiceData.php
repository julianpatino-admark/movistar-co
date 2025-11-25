<?php

namespace App\DTOs;

class ServiceData
{
    public function __construct(
        public string $icon,
        public string $text,
        public int $width = 26,
        public int $height = 26,
    ) {}
}