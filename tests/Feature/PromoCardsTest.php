<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;
use App\View\Components\PromoCards;
use Illuminate\View\View;

#[CoversClass(\App\View\Components\PromoCards::class)]
class PromoCardsTest extends TestCase
{
   public function test_el_componente_asigna_propiedades_y_renderiza_vista()
    {
        // 1. Instanciamos el componente con datos ficticios
        $component = new PromoCards('500 Mbps', 'Promo Navideña', '80.000', 'Texto legal aquí');

        // 2. Verificamos que guardó los datos correctamente en sus propiedades públicas
        $this->assertEquals('500 Mbps', $component->speed);
        $this->assertEquals('Promo Navideña', $component->promo);
        $this->assertEquals('80.000', $component->price);
        $this->assertEquals('Texto legal aquí', $component->text);

        // 3. Verificamos que el método render devuelva la vista correcta
        $view = $component->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('components.promo-cards', $view->name());
    }
}
