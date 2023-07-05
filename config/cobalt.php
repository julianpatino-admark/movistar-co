<?php
return [

    /**
     * Endpoint del cliente SOAP Cobalt (inserción de leads)
     */
    'endpoint' => 'http://panel.digitalion.com/wss/cobalt.php?wsdl',


    /**
     * La configuración del cliente SOAP Cobalt (inserción de leads)
     */
    'ws' => [
        'cache_wsdl' => WSDL_CACHE_NONE,
        'trace' => 1
    ],

    /**
     * La configuración del cliente SOAP de CobaltService
     */
    'service' => [
        'location' => env('COBALT_LOCATION', 'http://panel.digitalion.com/wss/cobalt.lp.php'),
        'uri' => env('COBALT_URI', 'urn:webservices'),
        'login' => env('COBALT_LOGIN'),
        'password' => env('COBALT_PASSWORD'),
        'encoding' => env('COBALT_ENCODING', 'UTF-8'),
        'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
    ],

    /*
    |--------------------------------------------------------------------
    | Extra data  que se debe enviar a Cobalt en params
    |--------------------------------------------------------------------
    */
    'extra_data' => [
        'dni',
        'nombre',
        'productos',
    ],

    /**
     * Configuración por defecto de los datos enviados
     */
    'default' => [

        'microsite' => 'ofertastienda.co',
        'page' => 'home',
        'client' => 'movistarco',
        'id_version' => 'default',
        'tsource' => 'default',
        'priority' => '4',
        'lead_type' => 'C2C',
        'provider' => 'b12-admark',
        'origin' => '1',
        'extra_observaciones' => true,

    ],

];
