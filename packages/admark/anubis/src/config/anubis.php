<?php
return [
    /*
    |--------------------------------------------------------------------
    | Credenciales del servicio
    |--------------------------------------------------------------------
    */
    'user' => env('ANUBIS_USER'),

    'password' => env('ANUBIS_PASSWORD'),

    /*
    |--------------------------------------------------------------------
    | URL del servicio de Anubis
    |--------------------------------------------------------------------
    */
    'url' => env('ANUBIS_URL', 'https://wsc2c.tlmark.com/Digital.asmx?WSDL'),

    /*
    |--------------------------------------------------------------------
    | El número de cliente de la campaña (Obtener de Anubis)
    |--------------------------------------------------------------------
    */
    'client' => env('ANUBIS_CLIENT'),

    /*
    |--------------------------------------------------------------------
    | Si se Genera o No id de lead
    |--------------------------------------------------------------------
    */
    'generate_id' => filter_var(env('ANUBIS_GENERATE_ID', false), FILTER_VALIDATE_BOOLEAN),
];
