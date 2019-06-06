<?php

namespace audunru\FikenClient\Traits;

use audunru\FikenClient\FikenClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

trait ConnectsToFiken
{
    private $guzzle;
    private $username;
    private $password;

    public function __construct()
    {
        $this->guzzle = new Client([
            'base_uri' => 'https://fiken.no/api/v1/',
        ]);
    }

    /**
     * Set username and password.
     *
     * @param string $username
     * @param string $password
     *
     * @return FikenClient
     */
    public function authenticate(string $username, string $password): FikenClient
    {
        $this->username = $username;
        $this->password = $password;

        return $this;
    }

    /**
     * Get a resouce from Fiken.
     *
     * @param string $link
     *
     * @return array
     */
    public function getResource(string $link = ''): array
    {
        if (! $this->username || ! $this->password) {
            throw new \Exception('Username and/or password not set');
        }
        try {
            $response = $this->guzzle->request('GET', $link, ['auth' => [$this->username, $this->password]]);
            $body = $response->getBody();

            return json_decode($body, true);
        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            $body = $response->getBody();

            throw new \Exception($body->getContents());
        }
    }

    /**
     * Post to a Fiken resource.
     *
     * @param string $link
     * @param array  $data
     * @param bool   $multipart
     *
     * @return string
     */
    public function postToResource(string $link, array $data = null, bool $multipart = false): string
    {
        if (! $this->username || ! $this->password) {
            throw new \Exception('Username and/or password not set');
        }
        $payload = ['auth' => [$this->username, $this->password]];
        if ($multipart) {
            $payload['multipart'] = $data;
        } else {
            $payload['json'] = $data;
        }

        try {
            $response = $this->guzzle->request('POST', $link, $payload);
            $location = $response->getHeader('Location')[0];

            return $location;
        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            $body = $response->getBody();

            throw new \Exception($body->getContents());
        }
    }
}
