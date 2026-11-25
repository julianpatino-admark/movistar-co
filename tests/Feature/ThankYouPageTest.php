<?php

namespace Tests\Feature;

use Tests\TestCase;

class ThankYouPageTest extends TestCase
{
    public function test_confirmation_uses_redesigned_chrome_without_conversion_forms(): void
    {
        $response = $this->get('/gracias')->assertOk()
            ->assertSee('class="movil-redesign thankyou-page"', false)
            ->assertSee('Hemos recibido tu registro correctamente,')
            ->assertSee('10 a 15 minutos')
            ->assertSee('Lunes a Viernes')
            ->assertSee('300 916 22 34')
            ->assertSee('300 917 66 10')
            ->assertSee('thankyou-content')
            ->assertSee('couple-')
            ->assertSee('id="modal-content"', false)
            ->assertDontSee('id="modal-retencion"', false)
            ->assertDontSee('data-toggle="form-simple"', false)
            ->assertDontSee('gracias@2x');

        $document = new \DOMDocument();
        @$document->loadHTML($response->getContent());
        $xpath = new \DOMXPath($document);
        $this->assertSame(1, $xpath->query('//main')->length);
        $this->assertSame(1, $xpath->query('//h1')->length);
        $this->assertSame(3, $xpath->query('//header//picture//*')->length);
        $this->assertSame(2, $xpath->query('//div[@class="thankyou__callback"]//a[starts-with(@href, "tel:")]')->length);
    }

    public function test_return_and_service_links_preserve_campaign_parameters(): void
    {
        $this->get('/gracias?tsource=0&utm_campaign=thanks')->assertOk()
            ->assertSee('href="'.url('/').'?tsource=0&amp;utm_campaign=thanks"', false)
            ->assertSee('href="/movil?tsource=0&amp;utm_campaign=thanks"', false)
            ->assertSee('href="/internet-hogar?tsource=0&amp;utm_campaign=thanks"', false)
            ->assertSee('href="/internet-movil?tsource=0&amp;utm_campaign=thanks"', false)
            ->assertDontSee('aria-current="page"', false);
    }

    public function test_nonum_campaign_keeps_sales_numbers_hidden(): void
    {
        $this->get('/gracias?keyword=nonum')->assertOk()
            ->assertDontSee('class="movil-header__phone', false)
            ->assertDontSee('class="movil-footer__phone', false)
            ->assertSee('tel:3009162234')
            ->assertSee('tel:3009176610');
    }
}
