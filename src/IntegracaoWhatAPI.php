<?php

namespace PauloAndrade\IntegracaoWhatAPI;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class IntegracaoWhatAPI
{
    protected $apikey;
    protected $instancia;
    protected $optionsRequest = [];
    private $client;

    function __construct($apikey, $instancia)
    {
        $config = [];
        $client = new Client([
            'base_uri' => 'http://easychatbot.sidsolucoes.com.br:8080', // URL base da API
            'timeout' => 10.0, // Tempo limite da solicitação em segundos
        ]);
        $this->apikey  = $apikey;
        $this->instancia = $instancia;
    }

    public function sendMessage($message, $numero)
    {
        $response = $this->client->request('POST', "message/sendText/$this->instancia", [
            'headers' => [
                'apikey' => "Bearer {$this->apikey}",
            ],
            'multipart' => [
                [
                    'name' => 'number',
                    'contents' => "55{$numero}"
                ],
                [
                    'name' => 'textMessage',
                    'contents' => "{'text': '.$message.'}"
                ]
            ],
            RequestOptions::HTTP_ERRORS => false // Não lançar exceções para respostas HTTP com códigos de erro
        ]);

        $responseBody = json_decode($response->getBody(), true);

        return $responseBody;
    }
}
