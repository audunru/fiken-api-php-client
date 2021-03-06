<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\FikenBaseModel;

class InvoiceLine extends FikenBaseModel
{
    protected $fillable = [
        'netAmount',
        'vatAmount',
        'grossAmount',
        'description',
        'comment',
        'vatType',
    ];

    protected $casts = [
        'netAmount'   => 'integer',
        'vatAmount'   => 'integer',
        'grossAmount' => 'integer',
    ];

    /**
     * Get product.
     */
    public function product(): ?Product
    {
        return Product::load($this->product);
    }

    /**
     * Set income account.
     */
    public function setIncomeAccount(Account $account): self
    {
        $this->incomeAccount = $account;

        return $this;
    }

    /**
     * Set product.
     */
    public function setProduct(Product $product): self
    {
        $this->product = $product;

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
            'netAmount'     => $this->netAmount,
            'vatAmount'     => $this->vatAmount,
            'grossAmount'   => $this->grossAmount,
            'description'   => $this->description,
            'comment'       => $this->comment,
            'vatType'       => $this->vatType,
            'productUrl'    => $this->product ? $this->product->getLinkToSelf() : null,
            'incomeAccount' => $this->incomeAccount ? $this->incomeAccount->code : null,
        ];
    }
}
