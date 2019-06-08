<?php

namespace audunru\FikenClient\Models;

class FikenCashSale extends FikenInvoice
{
    protected $casts = [
        'cash' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->cash = true;
    }

    /**
     * Set payment account.
     *
     * @param FikenAccount $account
     *
     * @return FikenCashSale
     */
    public function paymentAccount(FikenAccount $account): FikenCashSale
    {
        $this->paymentAccount = $account;

        return $this;
    }

    /*
     * Convert the model instance to an array that can be used to create a new resource
     *
     * @return array
     */
    public function toNewResourceArray(): array
    {
        return [
            'issueDate' => $this->issueDate,
            'dueDate' => $this->dueDate,
            'customer' => [
                'url' => $this->customer ? $this->customer->getLinkToSelf() : null,
            ],
            'bankAccountUrl' => $this->bankAccount ? $this->bankAccount->getLinkToSelf() : null,
            'invoiceText' => $this->invoiceText,
            'lines' => $this->lines,
            'cash' => $this->cash,
            'paymentAccount' => $this->paymentAccount ? $this->paymentAccount->code : null,
        ];
    }
}
