<?php

namespace audunru\FikenClient;

use Carbon\Carbon;

class FikenInvoice
{
    protected $issueDate;
    protected $dueDate;
    protected $lines;
    protected $customer;
    protected $bankAccountUrl;
    protected $invoiceText;

    public function __construct()
    {
    }

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

    public function invoiceText(string $text): FikenInvoice
    {
        $this->invoiceText = $text;

        return $this;
    }

    public function addLine(FikenInvoiceLine $line): FikenInvoice
    {
        $this->lines[] = $line->get();

        return $this;
    }

    public function get(): array
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
}
