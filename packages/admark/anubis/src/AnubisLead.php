<?php

namespace Admark\Anubis;

use Admark\Soap\Exceptions\MissingCredentialsException;
use Admark\Soap\Soap as Soap;
use Admark\Anubis\Exceptions\AnubisConnectionException;

class AnubisLead
{

    protected $soap;
    protected $client;

    public function __construct()
    {

        $this->client = config('anubis.client');

    }

    /**
     * @throws AnubisConnectionException
     */
    private function initSoap()
    {

        $user = config('anubis.user');
        $password = config('anubis.password');

        $options = [
            'cache_wsdl' => WSDL_CACHE_NONE,
            'stream_context' => stream_context_create([
                'ssl' => [
                    'verify_peer' => true,
                    'verify_peer_name' => true,
                ],
            ]),
        ];

        try {

            $this->soap = new Soap(config('anubis.url'), $options);

        } catch (\Exception $exception) {

            throw new AnubisConnectionException();

        }

        $this->soap->setCredentials($user, $password);

    }

    /**
     * @param $tsource
     * @param null $client
     * @return \SimpleXMLElement
     * @throws AnubisConnectionException
     */
    public function call($tsource, $client = null)
    {

        $this->initSoap();

        $client = ($client === null) ? $this->client : $client;

        $this->soap->setData([
            'CLIENTE' => $client,
            'TSOURCE' => $tsource
        ]);

        $response = $this->soap->call('C2C_Get_IDLEAD_V2');

        $xml = new \SimpleXMLElement($response->C2C_Get_IDLEAD_V2Result);


        return $xml;

    }

    /**
     * @param null $client
     * @return \SimpleXMLElement
     * @throws AnubisConnectionException
     */
    public function getSources($client = null)
    {

        $this->initSoap();

        $client = ($client === null) ? $this->client : $client;

        $this->soap->setData([
            'CLIENTE' => $client
        ]);

        $response = $this->soap->call('C2C_Get_TSOURCES');

        $xml = new \SimpleXMLElement($response->C2C_Get_TSOURCESResult);

        return $xml;

    }

    public function unsubscribe(array $subscriptionData){

        $this->initSoap();

        $subscriptionData['EMAIL'] = (array_key_exists('EMAIL',$subscriptionData))?$subscriptionData['EMAIL']:'';
        $subscriptionData['TELEFONO'] = (array_key_exists('TELEFONO',$subscriptionData))?$subscriptionData['TELEFONO']:'';

        $this->soap->setData($subscriptionData);

        $response = $this->soap->call('C2C_NOMASINFO');

        $xml = new \SimpleXMLElement($response->C2C_NOMASINFOResult);

        return $xml;

    }

    /**
     * @param $tsource
     * @param null $client
     * @return \SimpleXMLElement|string
     * @throws AnubisConnectionException
     */
    public function current($tsource, $client = null)
    {

        if (config('anubis.generate_id') === true) {

            $client = ($client === null) ? $this->client : $client;

            $xml = $this->call($tsource, $client);

            return $xml->LAST_LEAD;
        } else {

            return "no-id";

        }


    }

    /**
     * @param $tsource
     * @param null $client
     * @return string
     * @throws AnubisConnectionException
     */
    public function next($tsource, $client = null)
    {

        if (config('anubis.generate_id') === true) {

            $xml = $this->call($tsource, $client);

            $errorValue = (string) $xml->ERROR;
            $lastLeadValue = (string) $xml->LAST_LEAD;

            if (!empty($lastLeadValue) && $errorValue != 'SIN DATOS') {
                return $this->calculateNext($xml->RESULTADO, $lastLeadValue);
            }else{
                return $errorValue;
            }

        } else {

            return "no-id";

        }

    }

    /**
     * @param $code
     * @param $lastId
     * @return string
     */
    private function calculateNext($code, $lastId)
    {

        $id = explode('-', $lastId);

        $id = $id[1] + 1;

        $idLead = $code . '-' . $id;

        return $idLead;

    }

}
