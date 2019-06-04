<?php

namespace audunru\FikenClient\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

trait FetchesFromFiken
{
    public function __construct()
    {
        $this->guzzle = new Client([
            'base_uri' => 'https://fiken.no/api/v1/',
        ]);
    }

    public function get(string $path = ''): array
    {
        $body = $this->guzzle->get($path, ['auth' => [$this->username, $this->password]])->getBody();

        return json_decode($body, true);
    }

    public function post(string $path, array $payload): Response
    {
        $response = $this->guzzle->post($path, ['auth' => [$this->username, $this->password], 'json' => $payload]);

        return $response;
    }
}
