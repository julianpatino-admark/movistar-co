<?php

namespace Tests\Feature;

use Tests\TestCase;

class InternetMovilPageTest extends TestCase
{
    public function test_both_public_routes_render_the_figma_catalog_and_design(): void
    {
        foreach (['/', '/internet-movil'] as $path) {
            $response = $this->get($path.'?tsource=0&utm_campaign=fibra')->assertOk();
            $response->assertSee('internet-movil-redesign')
                ->assertSee('Movistar y Tigo')
                ->assertSee('id="internet-movil-content"', false)
                ->assertSee('id="internet-movil-banners"', false)
                ->assertSee('id="internet-movil-offers"', false)
                ->assertSee('data-phone-start="0"', false)
                ->assertSee('$149.900')->assertSee('$119.900')
                ->assertSee('20% DTO x 12 mes.')
                ->assertSee('¡LO QUIERO!')->assertSee('Plan recomendado')
                ->assertSee('Full Tigo')
                ->assertSee('data-c2c="FIBRA 900 + TV + POSPAGO ILIMITADO : 149.900"', false)
                ->assertSee('data-c2c="FIBRA 900 + POSPAGO ILIMITADO : 119.900"', false)
                ->assertDontSee('offert-carrousel-bogota-fibra');

            $document = new \DOMDocument();
            @$document->loadHTML('<?xml encoding="UTF-8">'.$response->getContent());
            $xpath = new \DOMXPath($document);
            $this->assertSame(1, $xpath->query('//h1')->length);
            $this->assertSame('Internet Hogar + Móvil', trim($xpath->evaluate('string(//nav[@class="movil-services"]//a[@aria-current="page"])')));
            $this->assertSame('/internet-movil?tsource=0&utm_campaign=fibra', $xpath->evaluate('string(//nav[@class="movil-services"]//a[@aria-current="page"]/@href)'));
        }
    }

    public function test_both_routes_keep_lead_forms_and_campaign_context(): void
    {
        foreach (['/', '/internet-movil'] as $path) {
            $this->get($path.'?tsource=0&utm_campaign=fibra')->assertOk()
                ->assertSee('id="c2c-internet-movil-desktop"', false)
                ->assertSee('name="tsource" value="0"', false)
                ->assertSee('name="batch_id" value="MOVISTARCO_KDMA_C2CLN_Q12"', false)
                ->assertSee('data-c2c="ASESORIA INTERNET FIBRA"', false)
                ->assertSee('data-c2c="INFORMACION INTERNET FIBRA"', false)
                ->assertSee('data-c2c="FIBRA 900 MEGAS + TV + POSPAGO ILIMITADO : 149.900"', false)
                ->assertSee('data-c2c="FIBRA 900 MEGAS + POSPAGO ILIMITADO : 119.900"', false);
        }
    }
}
