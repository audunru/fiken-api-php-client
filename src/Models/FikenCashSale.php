<?php

namespace audunru\FikenClient\Models;

class FikenCashSale extends FikenInvoice
{
    public function __construct()
    {
        parent::__construct();
        $this->cash = true;
    }

    public function paymentAccount(FikenAccount $account): FikenCashSale
    {
        $this->paymentAccount = $account;

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
            'cash' => $this->cash,
            'paymentAccount' => $this->paymentAccount->code,
        ];
    }
}
