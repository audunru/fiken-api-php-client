<?php

namespace audunru\FikenClient\Models;

class FikenInvoiceLine extends FikenBaseModel
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
        'netAmount' => 'integer',
        'vatAmount' => 'integer',
        'grossAmount' => 'integer',
    ];

    /**
     * Get product.
     *
     * @return FikenProduct|null
     */
    public function product(): ?FikenProduct
    {
        return FikenProduct::load($this->product);
    }

    /**
     * Set income account.
     *
     * @param FikenAccount $account
     *
     * @return FikenInvoiceLine
     */
    public function setIncomeAccount(FikenAccount $account): FikenInvoiceLine
    {
        $this->incomeAccount = $account;

        return $this;
    }

    /**
     * Set product.
     *
     * @param FikenProduct $product
     *
     * @return FikenInvoiceLine
     */
    public function setProduct(FikenProduct $product): FikenInvoiceLine
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
            'netAmount' => $this->netAmount,
            'vatAmount' => $this->vatAmount,
            'grossAmount' => $this->grossAmount,
            'description' => $this->description,
            'comment' => $this->comment,
            'vatType' => $this->vatType,
            'productUrl' => $this->product ? $this->product->getLinkToSelf() : null,
            'incomeAccount' =>  $this->incomeAccount ? $this->incomeAccount->code : null,
      ];
    }
}
