<?php

namespace audunru\FikenClient;

use GuzzleHttp\Client;

class FikenClient
{
    private $client;
    private $username;
    private $password;
    private $company;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://fiken.no/api/v1/',
        ]);
    }

    public function username(string $username)
    {
        $this->username = $username;

        return $this;
    }

    public function password(string $password)
    {
        $this->password = $password;

        return $this;
    }

    public function company(FikenCompany $company)
    {
        $this->company = $company;

        return $this;
    }

    public function whoAmI()
    {
        return $this->client->get('whoAmI', ['auth' => $this->auth()]);
    }

    public function createInvoice(FikenInvoice $invoice)
    {
        $link = $this->company->getLink('https://fiken.no/api/v1/rel/create-invoice-service');

        return $this->client->request('POST', $link, ['auth' => $this->auth(), 'json' => $invoice->get()]);
    }

    private function auth()
    {
        return [$this->username, $this->password];
    }

    public function companies()
    {
        $body = $this->client->get('', ['auth' => $this->auth()])->getBody();
        $json = json_decode($body, true);
        $link = $json['_links']['https://fiken.no/api/v1/rel/companies']['href'];

        $body = $this->client->get($link, ['auth' => $this->auth()])->getBody();
        $json = json_decode($body, true);

        return collect($json['_embedded']['https://fiken.no/api/v1/rel/companies'])->map(function ($data) {
            return new FikenCompany($data);
        });
    }

    public function findCompanyByOrganizationNumber($organizationNumber)
    {
        return $this->companies()->first(function ($company) use ($organizationNumber) {
            return $organizationNumber == $company->organizationNumber;
        });
    }

    public function contacts()
    {
        $link = $this->company->getLink('https://fiken.no/api/v1/rel/contacts');

        $body = $this->client->get($link, ['auth' => $this->auth()])->getBody();
        $json = json_decode($body, true);

        return collect($json['_embedded']['https://fiken.no/api/v1/rel/contacts'])->map(function ($data) {
            return new FikenContact($data);
        });
    }

    public function findContactByName($name)
    {
        return $this->contacts()->first(function ($contact) use ($name) {
            return $name == $contact->name;
        });
    }

    public function bankAccounts()
    {
        $link = $this->company->getLink('https://fiken.no/api/v1/rel/bank-accounts');

        $body = $this->client->get($link, ['auth' => $this->auth()])->getBody();
        $json = json_decode($body, true);

        return collect($json['_embedded']['https://fiken.no/api/v1/rel/bank-accounts'])->map(function ($data) {
            return new FikenBankAccount($data);
        });
    }

    public function findBankAccountByName($name)
    {
        return $this->bankAccounts()->first(function ($bankAccount) use ($name) {
            return $name == $bankAccount->name;
        });
    }
}
