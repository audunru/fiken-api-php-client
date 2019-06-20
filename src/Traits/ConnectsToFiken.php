<?php

namespace audunru\FikenClient\Traits;

use audunru\FikenClient\Exceptions\AuthenticationFailedException;
use audunru\FikenClient\Exceptions\InvalidContentException;
use audunru\FikenClient\Exceptions\ModelNotFoundException;
use audunru\FikenClient\FikenClient;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;

trait ConnectsToFiken
{
    /**
     * The Guzzle HTTP client.
     *
     * @var Client
     */
    private $guzzle;

    /**
     * Fiken username.
     *
     * @var string
     */
    private $username;

    /*
     * Fiken password.
     *
     * @var string
     */
    private $password;

    public function __construct(array $options = [])
    {
        $this->username = $options['username'] ?? null;
        $this->password = $options['password'] ?? null;
        $this->guzzle = new Client([
            'base_uri' => static::BASE_URI,
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
            throw new AuthenticationFailedException('Username and/or password not set');
        }
        try {
            $response = $this->guzzle->request('GET', $link, ['auth' => [$this->username, $this->password]]);
            $body = $response->getBody();

            return json_decode($body, true);
        } catch (ConnectException $exception) {
            throw new Exception('Network error');
        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            $body = $response->getBody();

            if (404 === $exception->getCode()) {
                throw new ModelNotFoundException("404 Not Found: {$link}");
            } else {
                throw new Exception($body->getContents(), $exception->getCode());
            }
        }
    }

    /**
     * Create a new Fiken resource.
     *
     * @param string $link
     * @param array  $data
     * @param bool   $multipart
     *
     * @return string
     */
    public function createResource(string $link, array $data = null, bool $multipart = false): string
    {
        if (! $this->username || ! $this->password) {
            throw new AuthenticationFailedException('Username and/or password not set');
        }
        $payload = ['auth' => [$this->username, $this->password]];
        if ($multipart) {
            // Payload is multipart (i.e. file upload)
            $payload['multipart'] = $data;
        } else {
            $payload['json'] = $data;
        }

        try {
            $response = $this->guzzle->request('POST', $link, $payload);
            // Location header contains a URL to the newly created resource
            $location = $response->getHeader('Location')[0];

            return $location;
        } catch (ConnectException $exception) {
            throw new Exception('Network error');
        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            $body = $response->getBody();

            if (400 === $exception->getCode()) {
                throw new InvalidContentException($body->getContents());
            } else {
                throw new Exception($body->getContents(), $exception->getCode());
            }
        }
    }

    /**
     * Update a Fiken resource.
     *
     * @param string $link
     * @param array  $data
     * @param bool   $multipart
     *
     * @return string
     */
    public function updateResource(string $link, array $data = null, bool $multipart = false): ?string
    {
        if (! $this->username || ! $this->password) {
            throw new AuthenticationFailedException('Username and/or password not set');
        }
        $payload = ['auth' => [$this->username, $this->password]];
        if ($multipart) {
            // Payload is multipart (i.e. file upload)
            $payload['multipart'] = $data;
        } else {
            $payload['json'] = $data;
        }

        try {
            $response = $this->guzzle->request('PUT', $link, $payload);

            // Fiken returns an empty body on successful updates, so we just return
            return null;
        } catch (ConnectException $exception) {
            throw new Exception('Network error');
        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            $body = $response->getBody();

            if (400 === $exception->getCode()) {
                throw new InvalidContentException($body->getContents());
            } else {
                throw new Exception($body->getContents(), $exception->getCode());
            }
        }
    }
}
