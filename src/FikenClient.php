<?php

namespace audunru\FikenClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

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

    public function authenticate(string $username, string $password): FikenClient
    {
        $this->username = $username;
        $this->password = $password;

        return $this;
    }

    public function company(FikenCompany $company): FikenClient
    {
        $this->company = $company;

        return $this;
    }

    public function whoAmI(): Response
    {
        return $this->client->get('whoAmI', ['auth' => $this->auth()]);
    }

    public function createInvoice(FikenInvoice $invoice): Response
    {
        $link = $this->company->getLink('https://fiken.no/api/v1/rel/create-invoice-service');

        return $this->client->request('POST', $link, ['auth' => $this->auth(), 'json' => $invoice->get()]);
    }

    private function auth(): array
    {
        return [$this->username, $this->password];
    }

    public function companies(): Collection
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

    public function findCompanyByOrganizationNumber(string $organizationNumber): ?FikenCompany
    {
        return $this->companies()->first(function ($company) use ($organizationNumber) {
            return $organizationNumber == $company->organizationNumber;
        });
    }

    public function contacts(): Collection
    {
        $link = $this->company->getLink('https://fiken.no/api/v1/rel/contacts');

        $body = $this->client->get($link, ['auth' => $this->auth()])->getBody();
        $json = json_decode($body, true);

        return collect($json['_embedded']['https://fiken.no/api/v1/rel/contacts'])->map(function ($data) {
            return new FikenContact($data);
        });
    }

    public function findContactByName(string $name): ?FikenContact
    {
        return $this->contacts()->first(function ($contact) use ($name) {
            return $name == $contact->name;
        });
    }

    public function bankAccounts(): Collection
    {
        $link = $this->company->getLink('https://fiken.no/api/v1/rel/bank-accounts');

        $body = $this->client->get($link, ['auth' => $this->auth()])->getBody();
        $json = json_decode($body, true);

        return collect($json['_embedded']['https://fiken.no/api/v1/rel/bank-accounts'])->map(function ($data) {
            return new FikenBankAccount($data);
        });
    }

    public function findBankAccountByNumber(string $number): ?FikenBankAccount
    {
        return $this->bankAccounts()->first(function ($bankAccount) use ($number) {
            return $number == $bankAccount->number;
        });
    }

    public function products(): Collection
    {
        $link = $this->company->getLink('https://fiken.no/api/v1/rel/products');

        $body = $this->client->get($link, ['auth' => $this->auth()])->getBody();
        $json = json_decode($body, true);

        return collect($json['_embedded']['https://fiken.no/api/v1/rel/products'])->map(function ($data) {
            return new FikenProduct($data);
        });
    }

    public function findProductByName(string $name): ?FikenProduct
    {
        return $this->products()->first(function ($product) use ($name) {
            return $name == $product->name;
        });
    }

    public function accounts(int $year): Collection
    {
        $link = $this->company->getLink('https://fiken.no/api/v1/rel/accounts');

        $body = $this->client->get(str_replace('{year}', $year, $link), ['auth' => $this->auth()])->getBody();
        $json = json_decode($body, true);

        return collect($json['_embedded']['https://fiken.no/api/v1/rel/accounts'])->map(function ($data) {
            return new FikenAccount($data);
        });
    }

    public function findAccountByCode(string $code, int $year): ?FikenAccount
    {
        return $this->accounts($year)->first(function ($account) use ($code) {
            return $code == $account->code;
        });
    }

    // TODO: Needs refactoring
    public function findAttachmentLinkByInvoice(string $invoice): string
    {
        $body = $this->client->get($invoice, ['auth' => $this->auth()])->getBody();
        $json = json_decode($body, true);

        $sale = $json['sale'];

        $body = $this->client->get($sale, ['auth' => $this->auth()])->getBody();
        $json = json_decode($body, true);

        return $json['_links']['https://fiken.no/api/v1/rel/attachments']['href'];
    }

    // TODO: Needs refactoring
    public function createAttachment(string $link, string $path, string $filename)
    {
        return $this->client->request('POST', $link, [
            'auth' => $this->auth(),
            'multipart' => [
                [
                    'name'     => 'AttachmentFile',
                    'contents' => fopen($path, 'rb'),
                    'filename' => $filename,
                ],
                [
                    'name'     => 'SaleAttachment',
                    'contents' => json_encode([
                        'filename' => $filename,
                        'attachToPayment' => false,
                        'attachToSale' => true,
                    ]),
                ],
            ],
        ]);
    }
}
