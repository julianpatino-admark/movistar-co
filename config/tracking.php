<?php
return array(

    /**
     * Seleccionar servicio para insertar leads
     * Admark\Inconcert\Inconcert
     * Admark\Transcom\Transcom
     */
    'api' => 'Admark\Cobalt\Cobalt',


    /*
    |--------------------------------------------------------------------
    | Contraseña para los envíos de formularios a través del Webhook
    |--------------------------------------------------------------------
    */
    'webhook_password' => 'secret',

    /*
    |--------------------------------------------------------------------
    | Contraseña para los envíos de formularios a través del Webhook
    |--------------------------------------------------------------------
    */
    'webhook_tsource' => '0',

    /*
    |--------------------------------------------------------------------
    | El prefijo a eliminar en los teléfonos del webhook
    |--------------------------------------------------------------------
    */
    'webhook_phone_prefix' => '+57',

    /*
    |--------------------------------------------------------------------
    | Validación a realizar sobre los teléfonos enviados a través de los formularios
    |--------------------------------------------------------------------
    */
    'phone_validation'  =>  'COL',

    /*
    |--------------------------------------------------------------------
    | Listado de validaciones de teléfonos (Expresiones regulares)
    |--------------------------------------------------------------------
    */
    'phone_validations' => [

        "ES" => "/^(9|8|7)[1-9]{1}[0-9]{7}|^(6|7)[0-9]{8}$/",
        "COL" => "/^(\+?57)?((60[1-9]|1\d|2[0-4]|5(0|1))\d{7})|((3\d{2})(\d{3})((\d{4})))$/", //^(\+?57)?((60[1-9]|1\d|2[0-4]|5(0|1))\d{7})|((3\d{2})(\d{3})((\d{4})))$
        "CL" => "/^(2|9)[0-9]{8}$|^(32|33|34|35|39|41|42|43|44|45|51|52|53|55|57|58|61|63|64|65|67|68|71|72|73|75)[0-9]{7}$/",
        "RD" => "/^(\+?1)?8[024]9\d{7}$/",
        "CR" => "/^(\+?506)?[2-8]\d{7}$/",
        "BR" => "/^[0-9]{2}[9][0-9]{8}$/"

    ],

    /*
    |--------------------------------------------------------------------
    | El formato del teléfono para las vistas (ES, ES_GEO, COL, CH, PE)
    |--------------------------------------------------------------------
    */
    'phone_format' => 'COL',

    /*
    |--------------------------------------------------------------------
    | Listado de formatos de teléfono
    |--------------------------------------------------------------------
    */
    'phone_formats' => [

        'BR' => '0000 000 000',

        'CL_GEO' => '0 000 000 00',
        'CL' => '000 000 000',

        'COL' => [
            "regex" => '/(57)?(\d{3})(\d{7})/',
            "format" => '$2 $3'
        ],
        'COL_GEO' => '00 0000 000 000',

        'CR' => '000 0000 0000',

        'ES' => '000 000 000',
        'ES_GEO' => '00 000 00 00',

        'PE' => '0 000 00000',

        'RD' => '0 000 0000 0000',
        'RD_GEO' => '000 000 0000',


    ],

    /*
    |-----------------------------------------------------------------------
    | Versión de privacidad que aceptará el usuario al enviar el formulario
    |-----------------------------------------------------------------------
    */
    'privacy_version'   =>  '1.0',

    /*
    |----------------------------------------------------------------------------------
    | Número de leads que se suman manualmente al total de leads calculado por la app
    | El número de leads se debe especificar por versión de landing
    |----------------------------------------------------------------------------------
    */
    'leads_addition' => [
        'index' => 10
    ],

    /*
    |--------------------------------------------------------------------------------------------------
    | Repositorio de tsources
    |--------------------------------------------------------------------------------------------------
    | config
    | database
    */
    'driver' => 'database',

    /*
    |--------------------------------------------------------------------------------------------------
    | Sólo con driver database. Qué campo de Anubis nos va a servir para generar los eventos de Google Tag Manager y lanzar los píxeles adecuados en las conversiones.
    |--------------------------------------------------------------------------------------------------
    */
    'pixel'  => 'pixel',

    /*
    |--------------------------------------------------------------------------------------------------
    | Que teléfono se debe obtener al actualizar tsources
    |--------------------------------------------------------------------------------------------------
    | N900
    | geografico
    */
    'phone_source' => 'N900',

    /*
    |--------------------------------------------------------------------------------------------------
    | Orígenes con sus propiedades, cualquier propiedad que no exista devolverá los valores de default
    |--------------------------------------------------------------------------------------------------
    | phone     => el teléfono
    | provider  => el proveedor asociado al tsource
    | batch_id  => el lote dónde se insertarán los leads
    | priority  => la prioridad (500 => no prioridad | > 1000 en múltiplos de 100 => definir prioridad)
    */

    'source_phones'   =>  [
        '1' =>  [
            'phone' => '900000001',
            'provider' => 'admark',
            'batch_id' => 'BATCH_1',
            'campaign' => 'CAMPAIGN_1',
            'priority' => 1000
        ],
        '2' =>  [
            'phone' => '900000002',
            'provider' => 'adwords',
            'batch_id' => 'BATCH_2',
            'priority' => 2000
        ],
        '3' =>  [
            'phone' => '900000003',
            'provider' => 'doubleclick',
            'batch_id' => 'BATCH_3',
            'priority' => 3000
        ],
        '63' => [
            'phone' => '900900963',
            'provider' => 'provider63',
            'batch_id' => 'batch63',
            'priority' => 63,
            'campaign' => 'CAMPAIGN_63',
            'adgroup_id' => '121408083769-118001226663-115637335574-123332188478',
        ],
        'default' => [
            'phone' => '601 0011217',
            'provider' => 'admark',
            'batch_id' => 'BATCH_DEFAULT',
            'batch_suffix' => '_SUFFIX',
            'priority' => 500
        ]
    ],

    /**
     * Versiones de landing que se envían a inConcertç
     * 'index' => 'LANDING_GENERICA'
     */
    'version_landing' => [

    ],

    /**
     * Parámetros de URL a guardar en la sesión
     */
    'session_data' => [
        'gclid',
        'keyword',
        'adkeyword'
    ],

    /**
     * Cookies que se quieren guardar en la base de datos en los envíos de formulario
     */
    'cookies_data' => [

    ],

    /*
    |--------------------------------------------------------------------------------------------------
    | Teléfonos que se quiere impedir su inserción en inconcert
    |--------------------------------------------------------------------------------------------------
    | String que contiene los teléfonos baneados
    | Separar teléfonos con |
    | No se puede dejar vacio el string
    */
    'banned_phones' => '606963220',

    /**
     * Validación de los datos extra enviados por los formularios
     * Importante rellenarla aunque los datos no sean cumplimentados por el propio usuario
     * Más información en https://laravel.com/docs/8.x/validation
     */
    'extra_data_validation' => [

    ],

    /**
     * Array con la lista de emails que van a recibir el reporte de nuevos tsources configurados
     */
    'report_recipients' => [

        'victor.molero@grupoadmark.com'

    ],

    /**
     * Configuración predeterminada para el envío de notificaciones internas
     */
    'push' => [

        'default_icon' => 'https://push.grupoadmark.com/public_storage/folder-1/image-2.jpg',
        'default_host' => 'repositoriojs.local:8890'

    ],

    'ftp_root' => '/'

);