<?php

namespace audunru\FikenClient;

class FikenCashSale extends FikenInvoice
{
    protected $cash;

    public function __construct()
    {
        parent::__construct();
        $this->cash = true;
    }

    public function paymentAccount(string $paymentAccount): FikenCashSale
    {
        $this->paymentAccount = $paymentAccount;

        return $this;
    }

    public function get(): array
    {
        return [
            'issueDate' => $this->issueDate->format('Y-m-d'),
            'dueDate' => $this->dueDate->format('Y-m-d'),
            'customer' => $this->customer,
            'bankAccountUrl' => $this->bankAccountUrl,
            'lines' => $this->lines,
            'cash' => $this->cash,
            'paymentAccount' => $this->paymentAccount,
        ];
    }
}
