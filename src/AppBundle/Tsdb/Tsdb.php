<?php

namespace AppBundle\Tsdb;

use GuzzleHttp\Client;
use JMS\Serializer\Serializer;

class Tsdb {

    private $tsdbClient;
    private $serializer;
    private $apiKey;
    private $plId;

    public function __construct(Client $tsdbClient, Serializer $serializer, $apiKey, $plId) {
        $this->tsdbClient = $tsdbClient;
        $this->serializer = $serializer;
        $this->apiKey = $apiKey;
        $this->plId = $plId;
    }

    // Récupère le classement de premier league
    // Paramètre : saison (exemple: 1718 pour la saison 2017-2018)
    public function getStanding($season = null) {
        if ($season != null) {
            $uri = '/api/v1/json/' . $this->apiKey . '/lookuptable.php?l='.$this->plId.'&s=' . $season;
        } else {
            $uri = '/api/v1/json/' . $this->apiKey . '/lookuptable.php?l='.$this->plId;
        }
        try {
            $response = $this->tsdbClient->get($uri);
        } catch (Exception $ex) {
            return ['error' => 'Les informations ne sont pas disponibles pour le moment.'];
        }

        $data = $this->serializer->deserialize($response->getBody()->getContents(), 'array', 'json');

        return $data;
    }

    // Récupère les matchs de premier league par journée
    // Paramètre : saison (exemple: 1718 pour la saison 2017-2018)
    // Paramètre : journée (exemple: 38 pour la 38e journée )
    public function getMatchesByRound($season, $round) {
        https://www.thesportsdb.com/api/v1/json/1/eventsround.php?id=4328&r=38&s=1415
        $uri = '/api/v1/json/' . $this->apiKey . '/eventsround.php?id='.$this->plId.'&r='.$round.'&s=' . $season;
        try {
            $response = $this->tsdbClient->get($uri);
        } catch (Exception $ex) {
            return ['error' => 'Les informations ne sont pas disponibles pour le moment.'];
        }

        $data = $this->serializer->deserialize($response->getBody()->getContents(), 'array', 'json');

        return $data;
    }
    
}
