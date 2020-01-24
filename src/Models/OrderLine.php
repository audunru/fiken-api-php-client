<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\FikenBaseModel;

class OrderLine extends FikenBaseModel
{
    protected $fillable = [
        'description',
        'netPrice',
        'vat',
        'vatType',
        'netPriceInCurrency',
        'vatInCurrency',
    ];

    protected $casts = [
        'netPrice'           => 'integer',
        'vat'                => 'integer',
        'netPriceInCurrency' => 'integer',
        'vatInCurrency'      => 'integer',
    ];

    /**
     * Set income account.
     */
    public function setAccount(Account $account): self
    {
        $this->account = $account;

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
            'description'        => $this->description,
            'netPrice'           => $this->netPrice,
            'vat'                => $this->vat,
            'account'            => $this->account ? $this->account->code : null,
            'vatType'            => $this->vatType,
            'netPriceInCurrency' => $this->netPriceInCurrency,
            'vatInCurrency'      => $this->vatInCurrency,
        ];
    }
}
