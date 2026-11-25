<?php

return [
    // APP_URL differs between Cloud Run services; search signals always use this origin.
    'public_url' => rtrim(env('SEO_PUBLIC_URL', 'https://ofertastienda.co'), '/'),
    'site_name' => 'Ofertas Tienda',
    'alternate_name' => 'Ofertastienda',
    'aliases' => ['/internet-movil' => '/'],
    'sitemap_paths' => ['/', '/internet-hogar', '/movil'],
];
