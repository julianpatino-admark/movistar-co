<?php
return array(
    /*
    |--------------------------------------------------------------------
    | Si las llamadas a Inconcert se harán realmente o no
    |--------------------------------------------------------------------
    */
    'test' 				=> 			false,

    /*
    |--------------------------------------------------------------------
    | Datos campaña Inconcert
    |--------------------------------------------------------------------
    */
    /**
     * Puerto o URL de inconcert (CON PROTOCOLO HTTP O HTTPS)
     */
    'server_ip' 		=>			"http://52.210.157.225",
    'port' 				=>  		"8085",
    'import_id' 		=> 			"",
    'vcc' 				=> 			"",
    'flow_state' 		=> 			"InsertLead4",
    'campaign' 			=>  		"",
    'batch_id' 			=> 			"",
    'phone_type' 		=> 			"HOME",
    'country_id' 		=> 			"+57",
    'area_id' 			=> 			"",
    'schedule_date' 	=> 			"",
    'time_zone' 		=> 			"CET",
    'contact_id_prefix' => 			"CRC2C_",
    'number_prefix' 	=> 			"+57",
    /*
    |--------------------------------------------------------------------
    | Horas que tienen que pasar para que se pueda realizar otra
    | inserción del mismo número de teléfono
    |--------------------------------------------------------------------
    */
    'repeat_hours' 		=> 			1,

    /*
    |--------------------------------------------------------------------
    | Extra data  que se debe enviar a inconcert
    |--------------------------------------------------------------------
    */
    'extra_data'        => [
        'gclid',
        'adkeyword',
        'keyword'
    ],
    /*
    |--------------------------------------------------------------------
    | Extra data  que se debe limpiar antes de enviar a inconcert
    |--------------------------------------------------------------------
    */
    'sanitize'     => [

    ]
);