<?php

namespace PauloAndrade\IntegracaoWhatAPI;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class IntegracaoWhatAPI
{
    protected $token;
    protected $bearer;
    protected $optionsRequest = [];
    private $client;

    function __construct($token, $bearer)
    {
        $config = [];
        $client = new Client([
            'base_uri' => 'https://app.whatapi.com.br/', // URL base da API
            'timeout' => 10.0, // Tempo limite da solicitação em segundos
        ]);
        $this->token  = $token;
        $this->bearer = $bearer;
    }

    public function sendMessage($message, $numero)
    {
        $response = $this->client->request('POST', 'rest-api/sendText', [
            'headers' => [
                'Authorization' => "Bearer {$this->bearer}",
            ],
            'multipart' => [
                [
                    'name' => 'tokenid',
                    'contents' => "{$this->token}"
                ],
                [
                    'name' => 'numero',
                    'contents' => "55{$numero}"
                ],
                [
                    'name' => 'mensagem',
                    'contents' => "{$message}"
                ]
            ],
            RequestOptions::HTTP_ERRORS => false // Não lançar exceções para respostas HTTP com códigos de erro
        ]);

        $responseBody = json_decode($response->getBody(), true);

        return $responseBody;
    }
}
