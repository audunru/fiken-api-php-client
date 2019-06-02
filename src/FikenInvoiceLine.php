<?php

namespace audunru\FikenClient;

class FikenInvoiceLine
{
    private $netAmount;
    private $vatAmount;
    private $grossAmount;
    private $vatType;
    private $incomeAccount;
    private $description;
    private $comment;
    private $product;

    public function __construct()
    {
    }

    public function price(int $netAmount, int $vatAmount, int $grossAmount): FikenInvoiceLine
    {
        $this->netAmount = $netAmount;
        $this->vatAmount = $vatAmount;
        $this->grossAmount = $grossAmount;

        return $this;
    }

    public function vatType(string $vatType): FikenInvoiceLine
    {
        $this->vatType = $vatType;

        return $this;
    }

    public function description(string $description): FikenInvoiceLine
    {
        $this->description = $description;

        return $this;
    }

    public function comment(string $comment): FikenInvoiceLine
    {
        $this->comment = $comment;

        return $this;
    }

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
