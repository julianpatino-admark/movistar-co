<?php

namespace Tests\Feature;

use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    public function test_legal_pages_use_the_current_layout_and_keep_their_documents_available(): void
    {
        foreach (['privacy' => 'Política de privacidad', 'cookies' => 'Política de cookies'] as $path => $title) {
            $this->get('/'.$path.'?tsource=0&utm_campaign=legal')
                ->assertOk()
                ->assertSee('movil-redesign legal-page', false)
                ->assertSee('<h1>'.$title.'</h1>', false)
                ->assertSee('class="modal_content-data"', false)
                ->assertSee('id="modal-manual"', false)
                ->assertSee('aria-labelledby="modal-content-title"', false)
                ->assertSee('aria-labelledby="modal-manual-title"', false)
                ->assertSee('Políticas de privacidad')
                ->assertDontSee('id="modal-rgpd-config"', false)
                ->assertSee('class="movil-header"', false)
                ->assertSee('class="movil-footer"', false)
                ->assertDontSee('resources/sass/generica.scss', false)
                ->assertDontSee('cta-mobile_wrapper', false)
                ->assertDontSee('data-toggle="form-simple"', false);
        }

        $this->get('/privacy')->assertSee('Manual Políticas Tratamiento de Datos');
        $this->get('/cookies')->assertSee('Concepto de cookie y determinación de función.');
    }
}
