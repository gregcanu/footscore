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

    // Retourne le classement de premier league
    // Paramètre : saison (exemple: 1718 pour la saison 2017-2018)
    public function getStanding($season = null) {
        if ($season != null) {
            $uri = '/api/v1/json/' . $this->apiKey . '/lookuptable.php?l=' . $this->plId . '&s=' . $season;
        } else {
            $uri = '/api/v1/json/' . $this->apiKey . '/lookuptable.php?l=' . $this->plId;
        }
        try {
            $response = $this->tsdbClient->get($uri);
        } catch (Exception $ex) {
            return ['error' => 'Les informations ne sont pas disponibles pour le moment.'];
        }

        $data = $this->serializer->deserialize($response->getBody()->getContents(), 'array', 'json');

        return $data;
    }

    // Retourne les matchs de premier league par journée
    // Paramètre : saison (exemple: 1718 pour la saison 2017-2018)
    // Paramètre : journée (exemple: 38 pour la 38e journée )
    public function getMatchesByRound($season, $round) {
        $uri = '/api/v1/json/' . $this->apiKey . '/eventsround.php?id=' . $this->plId . '&r=' . $round . '&s=' . $season;
        try {
            $response = $this->tsdbClient->get($uri);
        } catch (Exception $ex) {
            return ['error' => 'Les informations ne sont pas disponibles pour le moment.'];
        }

        $data = $this->serializer->deserialize($response->getBody()->getContents(), 'array', 'json');

        return $data;
    }

    // Retourne les informations sur une équipe
    // Paramètre : id de l'équipe
    public function getTeam($idTeam) {
        $uri = '/api/v1/json/' . $this->apiKey . '/lookupteam.php?id=' . $idTeam;
        try {
            $response = $this->tsdbClient->get($uri);
        } catch (Exception $ex) {
            return ['error' => 'Les informations ne sont pas disponibles pour le moment.'];
        }

        $datas = $this->serializer->deserialize($response->getBody()->getContents(), 'array', 'json');
        $data = $datas["teams"][0];

        return $data;
    }

    // Retourne les joueurs d'une équipe
    // Paramètre : id de l'équipe
    public function getPlayersFromTeam($idTeam) {
        $uri = '/api/v1/json/' . $this->apiKey . '/lookup_all_players.php?id=' . $idTeam;
        try {
            $response = $this->tsdbClient->get($uri);
        } catch (Exception $ex) {
            return ['error' => 'Les informations ne sont pas disponibles pour le moment.'];
        }

        $datas = $this->serializer->deserialize($response->getBody()->getContents(), 'array', 'json');
        $data = $datas["player"];
        
        return $this->sortPlayersByPosition($data);
    }

    // Retourne 4 tableaux correspondants aux 4 postes des joueurs d'une équipe (Gardien, Défenseur, Milieu, Attaquant)
    // Paramètre : joueurs d'une équipe
    public function sortPlayersByPosition($players) {
        $playersSort = array();

        foreach ($players as $player) {
            switch ($player['strPosition']) {
                case "Goalkeeper":
                    $playersSort["goalkeeper"][] = $player;
                    break;
                case "Defender":
                    $playersSort["defender"][] = $player;
                    break;
                case "Midfielder":
                    $playersSort["midfielder"][] = $player;
                    break;
                case "Forward":
                    $playersSort["forward"][] = $player;
                    break;
            }
        }
        
        return $playersSort;
    }

}
