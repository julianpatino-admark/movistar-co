<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoTest extends TestCase
{
    public function test_public_landing_canonicals_use_the_final_production_url_without_campaign_parameters(): void
    {
        foreach (['/' => '/', '/internet-movil' => '/', '/internet-hogar' => '/internet-hogar', '/movil' => '/movil'] as $path => $canonicalPath) {
            $response = $this->get('https://ofertastienda.co'.$path.'?tsource=0&utm_campaign=seo&keyword=nonum')
                ->assertOk()->assertHeaderMissing('X-Robots-Tag');
            $html = $this->html($response->getContent());

            $this->assertSame(1, $html->query('//link[@rel="canonical"]')->length);
            $this->assertSame('https://ofertastienda.co'.$canonicalPath, $html->evaluate('string(//link[@rel="canonical"]/@href)'));
            $this->assertStringContainsString('Ofertas Tienda', $html->evaluate('string(//title)'));
            $this->assertStringContainsString('Movistar', $html->evaluate('string(//title)'));
            $this->assertStringContainsString('Ofertas Tienda', $html->evaluate('string(//meta[@name="description"]/@content)'));
            $this->assertSame(0, $html->query('//meta[@name="robots" and contains(@content,"noindex")]')->length);
            $response->assertSee('utm_campaign=seo', false);
        }
    }

    public function test_preview_and_alternate_hosts_are_noindex_with_production_canonicals(): void
    {
        foreach (['movistar-landing-fkgpi4yv5a-uc.a.run.app', 'movistar-landing-729520172510.us-central1.run.app', 'localhost', 'ofertastienda.co.example.org'] as $host) {
            $response = $this->get('https://'.$host.'/movil?tsource=0')->assertOk()
                ->assertHeader('X-Robots-Tag', 'noindex, follow');
            $this->assertSame('https://ofertastienda.co/movil', $this->html($response->getContent())->evaluate('string(//link[@rel="canonical"]/@href)'));
        }
    }

    public function test_homepage_identifies_the_site_in_valid_structured_data(): void
    {
        foreach (['/', '/internet-movil'] as $path) {
            $response = $this->get('https://ofertastienda.co'.$path)->assertOk();
            $html = $this->html($response->getContent());
            $data = json_decode($html->evaluate('string(//script[@type="application/ld+json"])'), true, flags: JSON_THROW_ON_ERROR);
            $this->assertSame('WebSite', $data['@type']);
            $this->assertSame('Ofertas Tienda', $data['name']);
            $this->assertSame('Ofertastienda', $data['alternateName']);
            $this->assertSame('https://ofertastienda.co/', $data['url']);
            $this->assertSame('Ofertas Tienda', $html->evaluate('string(//meta[@property="og:site_name"]/@content)'));
        }
    }

    public function test_sitemap_contains_distinct_canonical_landings_that_resolve(): void
    {
        $response = $this->get('https://ofertastienda.co/sitemap.xml')->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertHeaderMissing('Set-Cookie');
        $document = new \DOMDocument();
        $this->assertTrue($document->loadXML($response->getContent()));
        $this->assertSame('http://www.sitemaps.org/schemas/sitemap/0.9', $document->documentElement->namespaceURI);
        $urls = [];
        foreach ($document->getElementsByTagName('loc') as $location) {
            $url = $location->textContent;
            $urls[] = $url;
            $page = $this->get($url)->assertOk();
            $this->assertSame($url, $this->html($page->getContent())->evaluate('string(//link[@rel="canonical"]/@href)'));
        }
        $this->assertSame(['https://ofertastienda.co/', 'https://ofertastienda.co/internet-hogar', 'https://ofertastienda.co/movil'], $urls);
    }

    public function test_robots_advertises_the_public_sitemap_and_allows_reading_preview_noindex(): void
    {
        $expected = "User-agent: *\nDisallow:\n\nSitemap: https://ofertastienda.co/sitemap.xml\n";
        $this->get('https://ofertastienda.co/robots.txt')->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertHeaderMissing('Set-Cookie')->assertContent($expected);
        $this->get('https://movistar-landing-fkgpi4yv5a-uc.a.run.app/robots.txt')->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, follow')->assertContent($expected);
    }

    public function test_www_redirect_preserves_path_and_campaign_without_redirecting_post_requests(): void
    {
        $this->get('https://www.ofertastienda.co/internet-movil?tsource=0&utm_campaign=marca')
            ->assertStatus(301)->assertRedirect('https://ofertastienda.co/internet-movil?tsource=0&utm_campaign=marca');
        $this->head('https://www.ofertastienda.co/movil')->assertStatus(301)
            ->assertRedirect('https://ofertastienda.co/movil');
        $this->postJson('https://www.ofertastienda.co/api/seo-no-existe')->assertStatus(405)
            ->assertHeader('X-Robots-Tag', 'noindex, follow');
    }

    public function test_confirmation_and_not_found_pages_keep_their_noindex_directives(): void
    {
        foreach (['/gracias' => 200, '/no/existe/esta/url' => 404] as $path => $status) {
            $response = $this->get('https://ofertastienda.co'.$path)->assertStatus($status);
            $this->assertSame('noindex, follow', $this->html($response->getContent())->evaluate('string(//meta[@name="robots"]/@content)'));
        }
        $this->get('https://movistar-landing-fkgpi4yv5a-uc.a.run.app/no/existe/esta/url')->assertNotFound()
            ->assertHeader('X-Robots-Tag', 'noindex, follow');
    }

    private function html(string $content): \DOMXPath
    {
        $document = new \DOMDocument();
        @$document->loadHTML('<?xml encoding="UTF-8">'.$content);

        return new \DOMXPath($document);
    }
}
