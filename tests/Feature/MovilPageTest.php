<?php

namespace Tests\Feature;

use Tests\TestCase;

class MovilPageTest extends TestCase
{
    public function test_redesign_uses_current_figma_offers_and_conversion_forms(): void
    {
        $this->get('/movil')->assertOk()
            ->assertSee('class="movil-redesign movil-pospago"', false)
            ->assertSee('60 GB')
            ->assertSee('53.900')
            ->assertSee('69.900')
            ->assertSee('DATOS')
            ->assertSee('ILIMITADOS')
            ->assertSee('20% dto x 3 meses.')
            ->assertSee('Llamadas ilimitadas')
            ->assertSee('RED 4.5G / 5G')
            ->assertSee('data-c2c="MOVIL DE 60 GB : 53.900"', false)
            ->assertSee('data-c2c="MOVIL DE DATOS ILIMITADOS : 69.900"', false)
            ->assertDontSee('38.320')
            ->assertDontSee('43.120')
            ->assertDontSee('23.950')
            ->assertSee('data-target="#modal-velocidades"', false)
            ->assertSee('data-target="#modal-c2c"', false)
            ->assertSee('action="'.url('/api/form/send').'"', false)
            ->assertSee('href="tel:6010011217"', false)
            ->assertDontSee('Full Tigo');
    }

    public function test_service_links_preserve_campaign_parameters_and_current_page(): void
    {
        $response = $this->get('/movil?tsource=0&utm_campaign=pospago');

        $response->assertOk()
            ->assertSee('href="/internet-movil?tsource=0&amp;utm_campaign=pospago"', false)
            ->assertSee('href="/internet-hogar?tsource=0&amp;utm_campaign=pospago"', false)
            ->assertSee('data-c2c="INFORMACION MOVISTAR POSPAGO"', false);

        $document = new \DOMDocument();
        @$document->loadHTML($response->getContent());
        $xpath = new \DOMXPath($document);
        $this->assertSame('/movil?tsource=0&utm_campaign=pospago', $xpath->evaluate(
            'string(//nav[@class="movil-services"]//a[@aria-current="page"]/@href)'
        ));
    }

    public function test_nonum_campaign_hides_header_and_footer_numbers(): void
    {
        $this->get('/movil?keyword=nonum')->assertOk()
            ->assertDontSee('class="movil-header__phone', false)
            ->assertDontSee('class="movil-footer__phone', false)
            ->assertSee('data-target="#modal-c2c"', false);
    }

    public function test_desktop_form_keeps_tracking_fields_and_accessible_inputs(): void
    {
        $response = $this->get('/movil?tsource=0&utm_campaign=pospago')->assertOk();
        $document = new \DOMDocument();
        @$document->loadHTML($response->getContent());
        $xpath = new \DOMXPath($document);
        $form = '//form[@id="c2c-movil-desktop"]';

        $this->assertSame(1, $xpath->query($form)->length);
        $this->assertSame(url('/api/form/send'), $xpath->evaluate('string('.$form.'/@action)'));
        $this->assertSame('0', $xpath->evaluate('string('.$form.'//input[@name="tsource"]/@value)'));
        $this->assertSame('MOVISTARCO_KDMA_C2CLN_Q12', $xpath->evaluate('string('.$form.'//input[@name="batch_id"]/@value)'));
        foreach (['selectServicios', 'phone', 'name'] as $field) {
            $id = 'c2c-movil-desktop-'.$field;
            $this->assertSame(1, $xpath->query('//*[@id="'.$id.'" and @required]')->length);
            $this->assertSame(1, $xpath->query('//label[@for="'.$id.'"]')->length);
        }
    }
}
