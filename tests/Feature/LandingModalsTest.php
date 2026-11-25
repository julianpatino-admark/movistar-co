<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingModalsTest extends TestCase
{
    public function test_landing_modals_keep_unique_forms_tracking_and_accessible_controls(): void
    {
        foreach (['/', '/internet-movil', '/internet-hogar', '/movil'] as $path) {
            $response = $this->get($path.'?tsource=0')->assertOk()
                ->assertSee('¡No te vayas!')
                ->assertSee('Paramount+ y HBO')
                ->assertSee('¿Deseas comprar uno de nuestros planes?');
            $document = new \DOMDocument();
            @$document->loadHTML($response->getContent());
            $xpath = new \DOMXPath($document);
            foreach (['modal-retencion' => 'c2c-retencion', 'modal-c2c' => 'c2c-general', 'modal-velocidades' => 'c2c-velocidades'] as $modal => $form) {
                $this->assertSame(1, $xpath->query('//*[@id="'.$modal.'"]')->length);
                $this->assertSame(1, $xpath->query('//form[@id="'.$form.'"]')->length);
                $this->assertSame('0', $xpath->evaluate('string(//form[@id="'.$form.'"]//input[@name="tsource"]/@value)'));
                $this->assertSame('MOVISTARCO_KDMA_C2CLN_Q12', $xpath->evaluate('string(//form[@id="'.$form.'"]//input[@name="batch_id"]/@value)'));
                $this->assertSame(1, $xpath->query('//*[@id="'.$modal.'"]//button[@aria-label="Cerrar"]')->length);
                foreach (['phone', 'name'] as $field) {
                    $this->assertSame(1, $xpath->query('//label[@for="'.$form.'-'.$field.'"]')->length);
                }
            }
            $this->assertSame('/c2c/retencion/conversion', $xpath->evaluate('string(//form[@id="c2c-retencion"]/@data-layer-page)'));
            $this->assertSame(0, $xpath->query('//form[@id="c2c-velocidades"]//select')->length);
        }
    }
}
