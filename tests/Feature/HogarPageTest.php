<?php

namespace Tests\Feature;

use Tests\TestCase;

class HogarPageTest extends TestCase
{
    public function test_figma_offers_display_published_prices_without_discounting_them_again(): void
    {
        $response = $this->get('/internet-hogar')->assertOk();
        $xpath = $this->xpath($response->getContent());

        $this->assertSame(1, $xpath->query('//h1')->length);
        $prices = $xpath->query('//*[@id="hogar-offers"]//*[contains(@class,"card-offer_price-number")]');
        $this->assertCount(2, $prices);
        $this->assertSame('$109.155', trim($prices->item(0)->textContent));
        $this->assertSame('$84.900', trim($prices->item(1)->textContent));
        $response->assertSee('50% DTO x 1 mes.')
            ->assertSee('App 74 canales')
            ->assertSee('data-c2c="FIBRA 900 MEGAS + TV : 109.155"', false)
            ->assertSee('data-c2c="FIBRA 900 MEGAS SIMÉTRICAS : 84.900"', false)
            ->assertDontSee('42.450')
            ->assertDontSee('62.826');
    }

    public function test_hogar_navigation_and_conversion_keep_campaign_context(): void
    {
        $response = $this->get('/internet-hogar?tsource=0&utm_campaign=fibra')->assertOk();
        $xpath = $this->xpath($response->getContent());
        $form = '//form[@id="c2c-hogar-desktop"]';
        $this->assertSame('/internet-hogar?tsource=0&utm_campaign=fibra', $xpath->evaluate(
            'string(//nav[@class="movil-services"]//a[@aria-current="page"]/@href)'
        ));
        $this->assertSame(1, $xpath->query($form)->length);
        $this->assertSame(url('/api/form/send'), $xpath->evaluate('string('.$form.'/@action)'));
        $this->assertSame('0', $xpath->evaluate('string('.$form.'//input[@name="tsource"]/@value)'));
        foreach (['selectServicios', 'phone', 'name'] as $field) {
            $id = 'c2c-hogar-desktop-'.$field;
            $this->assertSame(1, $xpath->query('//*[@id="'.$id.'" and @required]')->length);
            $this->assertSame(1, $xpath->query('//label[@for="'.$id.'"]')->length);
        }
        $response->assertSee('data-c2c="ASESORIA INTERNET HOGAR"', false)
            ->assertSee('data-c2c="INFORMACION INTERNET HOGAR"', false);
        $this->get('/internet-hogar?keyword=nonum')->assertOk()
            ->assertDontSee('class="movil-header__phone', false)
            ->assertDontSee('class="movil-footer__phone', false);
    }

    private function xpath(string $html): \DOMXPath
    {
        $document = new \DOMDocument();
        @$document->loadHTML('<?xml encoding="UTF-8">'.$html);
        return new \DOMXPath($document);
    }
}
