<?php

namespace audunru\FikenClient\Models;

class FikenInvoiceLine extends FikenBaseModel
{
    public function incomeAccount(FikenAccount $account): FikenInvoiceLine
    {
        $this->incomeAccount = $account;

        return $this;
    }

    public function product(FikenProduct $product): FikenInvoiceLine
    {
        $this->product = $product;

        return $this;
    }

    public function get(): array
    {
        return [
            'netAmount' => $this->netAmount,
            'vatAmount' => $this->vatAmount,
            'grossAmount' => $this->grossAmount,
            'description' => $this->description,
            'comment' => $this->comment,
            'vatType' => $this->vatType,
            'productUrl' => $this->product ? $this->product->link() : null,
            'incomeAccount' =>  $this->incomeAccount ? $this->incomeAccount->code : null,
      ];
    }
}
