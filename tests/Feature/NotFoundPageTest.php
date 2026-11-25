<?php

namespace Tests\Feature;

use Tests\TestCase;

class NotFoundPageTest extends TestCase
{
    public function test_unknown_urls_at_any_depth_use_the_same_404_page(): void
    {
        foreach (['/pagina-inexistente', '/ofertas/inexistente', '/uno/dos/tres', '/uno/dos/tres/cuatro', '/api/pdf/no-existe.pdf'] as $url) {
            $this->get($url)->assertNotFound()
                ->assertSee('class="movil-redesign not-found-page"', false)
                ->assertSee('Página no encontrada')
                ->assertSee('Llévame a la home')
                ->assertSee('id="not-found-content"', false)
                ->assertSee('id="modal-content"', false)
                ->assertDontSee('id="modal-retencion"', false)
                ->assertDontSee('data-toggle="form-simple"', false)
                ->assertDontSee('/img/common/error-404.webp');
        }
    }

    public function test_campaign_navigation_and_phone_are_consistent_for_shallow_and_deep_urls(): void
    {
        config(['tracking.source_phones.404-test' => [
            'phone' => '3172534404',
            'provider' => 'telemark-interno',
        ]]);

        foreach (['/no-existe', '/no/existe/esta/url', '/internet-hogar/no/existe', '/internet-movil/no-existe'] as $url) {
            $response = $this->get($url.'?tsource=404-test&utm_campaign=error')->assertNotFound()
                ->assertSee('href="'.url('/').'?tsource=404-test&amp;utm_campaign=error"', false)
                ->assertSee('href="/movil?tsource=404-test&amp;utm_campaign=error"', false)
                ->assertSee('href="tel:3172534404"', false)
                ->assertDontSee('aria-current="page"', false);

            $document = new \DOMDocument();
            @$document->loadHTML($response->getContent());
            $xpath = new \DOMXPath($document);
            $this->assertSame(1, $xpath->query('//main')->length);
            $this->assertSame(1, $xpath->query('//h1')->length);
        }
    }

    public function test_nonum_campaign_hides_sales_numbers_on_deep_urls(): void
    {
        $this->get('/no/existe/esta/url?keyword=nonum')->assertNotFound()
            ->assertDontSee('class="movil-header__phone', false)
            ->assertDontSee('class="movil-footer__phone', false);
    }

    public function test_json_not_found_responses_remain_json(): void
    {
        $this->getJson('/no/existe/esta/url')->assertNotFound()
            ->assertHeader('Content-Type', 'application/json')
            ->assertDontSee('not-found-content');
    }

    public function test_existing_landing_pages_and_confirmation_still_resolve(): void
    {
        foreach (['/', '/internet-movil', '/internet-hogar', '/movil', '/gracias'] as $url) {
            $this->get($url)->assertOk()->assertDontSee('id="not-found-content"', false);
        }
    }
}
