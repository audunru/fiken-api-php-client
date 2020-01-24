<?php

namespace audunru\FikenClient\Traits;

use audunru\FikenClient\Exceptions\AuthenticationFailedException;
use audunru\FikenClient\Exceptions\FikenClientException;
use audunru\FikenClient\Exceptions\InvalidContentException;
use audunru\FikenClient\Exceptions\ModelNotFoundException;
use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Settings;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Response;

trait ConnectsToFiken
{
    /**
     * The Guzzle HTTP client.
     *
     * @var Client
     */
    private $guzzle;

    public function __construct(array $options = [])
    {
        Settings::setUsername($options['username'] ?? Settings::$username);
        Settings::setPassword($options['password'] ?? Settings::$password);
        $this->guzzle = new Client([
            'base_uri' => Settings::$baseUri,
        ]);
    }

    /**
     * Set username and password.
     */
    public function authenticate(string $username, string $password): FikenClient
    {
        Settings::setUsername($username);
        Settings::setPassword($password);

        return $this;
    }

    /**
     * Get a resouce from Fiken.
     */
    public function getResource(string $link = ''): array
    {
        $response = $this->connectToFiken($link);

        return json_decode($response->getBody(), true);
    }

    /**
     * Create a new Fiken resource.
     *
     * @param array $data
     */
    public function createResource(string $link, array $data = null, bool $multipart = false): string
    {
        if (true === $multipart) {
            // This is a file upload
            $payload = ['multipart' => $data];
        } else {
            $payload = ['json' => $data];
        }
        $response = $this->connectToFiken($link, 'POST', $payload);
        // Location header contains a URL to the newly created resource
        return $response->getHeader('Location')[0];
    }

    /**
     * Update a Fiken resource.
     *
     * @param array $data
     *
     * @return string|null
     */
    public function updateResource(string $link, array $data = null): string
    {
        $payload = ['json' => $data];

        $this->connectToFiken($link, 'PUT', $payload);

        // Fiken returns an empty body on successful updates, so we just return the link to the updated resource
        return $link;
    }

    /**
     * Send a GET, POST or PUT request to Fiken.
     */
    private function connectToFiken(string $link, string $method = 'GET', array $payload = []): Response
    {
        if (! Settings::$username || ! Settings::$password) {
            throw new AuthenticationFailedException('Username and/or password not set');
        }
        $auth = ['auth' => [Settings::$username, Settings::$password]];
        try {
            return $this->guzzle->request($method, $link, array_merge($auth, $payload));
        } catch (ConnectException $exception) {
            throw new Exception('Network error');
        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            $body = $response->getBody();

            if (400 === $exception->getCode()) {
                throw new InvalidContentException($body->getContents());
            } elseif (404 === $exception->getCode()) {
                throw new ModelNotFoundException("404 Not Found: {$link}");
            } else {
                throw new FikenClientException($body->getContents(), $exception->getCode());
            }
        }
    }
}
