<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;
use App\DTOs\OfferData;

#[CoversClass(\App\DTOs\OfferData::class)]
class OfferDataTest extends TestCase
{
    public function test_calcula_y_formatea_precios_con_descuento()
    {
        // Creamos una oferta de 100.000 con 20% de descuento
        $offer = new OfferData(speed: 100, price: 100000, discount: 20);

        // Verificamos las matemáticas (100.000 - 20% = 80.000)
        $this->assertEquals(80000.0, $offer->getDiscountPrice());

        // Verificamos el formato con puntos
        $this->assertEquals('100.000', $offer->getFormattedPrice());
        $this->assertEquals('80.000', $offer->getFormattedDiscountPrice());

        // Verificamos que el badge se genere automático
        $this->assertEquals('20% Dto. Exclusivo Online', $offer->getBadgeLabel());
    }

    public function test_maneja_valores_sin_descuento()
    {
        // Oferta sin descuento (null)
        $offer = new OfferData(speed: '200 Mbps', price: 150000, discount: null);

        // El precio final debe ser el mismo que el inicial
        $this->assertEquals(150000.0, $offer->getDiscountPrice());
        $this->assertEquals('150.000', $offer->getFormattedDiscountPrice());
        
        // No debe haber badge
        $this->assertNull($offer->getBadgeLabel());
    }

    public function test_etiqueta_personalizada_sobrescribe_descuento()
    {
        // Oferta con descuento PERO con una etiqueta personalizada
        $offer = new OfferData(
            speed: 500, 
            price: 50000, 
            discount: 10, 
            customBadgeLabel: '¡OFERTA FLASH!'
        );

        // Debe ignorar el "10% Dto." y mostrar el texto personalizado
        $this->assertEquals('¡OFERTA FLASH!', $offer->getBadgeLabel());
    }
}
