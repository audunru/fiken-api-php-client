<?php

namespace audunru\FikenClient\Tests;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\Company;

abstract class ClientTestCase extends TestCase
{
    /**
     * The Fiken client.
     *
     * @var FikenClient
     */
    protected $client;

    /**
     * A Fiken company.
     *
     * @var Company
     */
    protected $company;

    protected function setUp(): void
    {
        $this->client = new FikenClient();
        $this->client->authenticate($_ENV['FIKEN_TEST_USERNAME'], $_ENV['FIKEN_TEST_PASSWORD']);
        $this->company = $this->client->setCompany($_ENV['FIKEN_TEST_ORGANIZATION_NUMBER']);
    }
}
