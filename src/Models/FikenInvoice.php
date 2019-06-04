<?php

namespace audunru\FikenClient\Models;

use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;

class FikenInvoice extends FikenBaseModel
{
    protected static $rel = 'https://fiken.no/api/v1/rel/invoices';

    public function issueDate(Carbon $issueDate): FikenInvoice
    {
        $this->issueDate = $issueDate;

        return $this;
    }

    public function dueDate(Carbon $dueDate): FikenInvoice
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function customer(FikenContact $customer): FikenInvoice
    {
        $this->customer = $customer;

        return $this;
    }

    public function bankAccount(FikenBankAccount $bankAccount): FikenInvoice
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

    public function addLine(FikenInvoiceLine $line): FikenInvoice
    {
        $this->attributes['lines'][] = $line->toArray();

        return $this;
    }

    public function toArray(): array
    {
        return [
            'issueDate' => $this->issueDate->format('Y-m-d'),
            'dueDate' => $this->dueDate->format('Y-m-d'),
            'customer' => [
                'url' => $this->customer->link(),
            ],
            'bankAccountUrl' => $this->bankAccount->link(),
            'invoiceText' => $this->invoiceText,
            'lines' => $this->lines,
        ];
    }

    public function save(): Response
    {
        $link = $this->client->company->getRelationshipLink('https://fiken.no/api/v1/rel/create-invoice-service');

        return $this->client->post($link, $this->toArray());
    }
}
