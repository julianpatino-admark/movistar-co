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
    | Extra data  que se debe enviar a Cobalt
    |--------------------------------------------------------------------
    | type      => El tipo de campoo que se desea settear ['parametros', 'observaciones', 'ambos'] si no se quiere configurar se deja 'null'
    | encode    => El formato de la data extra sea tipo 'json' o como in 'string' con imploide de datos
    | separator => Separador que se quiere utilizar cualquier tipo de string (defecto '|') ej de salida => C2C|DIRECCION|SERVICIOS
    | keys      => Array de strings con las llaves que se desean capturar en los formularios
    */

    'extra_data' => [
        'type' => 'parametros',
        'encode' => 'string',
        'separator' => '|',
        'keys' => [
            'c2c',
            'servicios',
        ]
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
        'origin' => '1'
    ],

];
