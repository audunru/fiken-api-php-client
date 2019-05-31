<?php

namespace audunru\FikenClient;

use GuzzleHttp\Client;

class FikenClient
{
    private $client;
    private $username;
    private $password;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://fiken.no/api/v1/',
        ]);
    }

    public function username($username)
    {
        $this->username = $username;

        return $this;
    }

    public function password($password)
    {
        $this->password = $password;

        return $this;
    }

    public function whoAmI()
    {
        return $this->client->get('whoAmI', ['auth' => [$this->username, $this->password]]);
    }
}
