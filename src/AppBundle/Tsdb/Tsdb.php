<?php

namespace AppBundle\Tsdb;

use GuzzleHttp\Client;
use JMS\Serializer\Serializer;

class Tsdb
{
    private $tsdbClient;
    private $serializer;
    private $apiKey;

    public function __construct(Client $tsdbClient, Serializer $serializer, $apiKey)
    {
        $this->tsdbClient = $tsdbClient;
        $this->serializer = $serializer;
        $this->apiKey = $apiKey;
    }

    public function getStanding()
    {
        $uri = '/api/v1/json/'.$this->apiKey.'/lookuptable.php?l=4328';
        try {
            $response = $this->tsdbClient->get($uri);
        } catch (Exception $ex) {
            return ['error' => 'Les informations ne sont pas disponibles pour le moment.'];
        }

        $data = $this->serializer->deserialize($response->getBody()->getContents(), 'array', 'json');

//        return [
//            'city' => $data['name'],
//            'description' => $data['weather'][0]['main']
//        ];
        return $data;
    }
    
    public function isTest() {
        return 'yo';
    }
}