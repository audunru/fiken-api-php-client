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
    private $productUrl;

    public function __construct()
    {
    }

    public function price(int $netAmount, int $vatAmount, int $grossAmount)
    {
        $this->netAmount = $netAmount;
        $this->vatAmount = $vatAmount;
        $this->grossAmount = $grossAmount;

        return $this;
    }

    public function vatType(string $vatType)
    {
        $this->vatType = $vatType;

        return $this;
    }

    public function description(string $description)
    {
        $this->description = $description;

        return $this;
    }

    public function comment(string $comment)
    {
        $this->comment = $comment;

        return $this;
    }

    public function incomeAccount(int $incomeAccount)
    {
        $this->incomeAccount = $incomeAccount;

        return $this;
    }

    public function productUrl(string $productUrl)
    {
        $this->productUrl = $productUrl;

        return $this;
    }

    public function get()
    {
        return [
            'netAmount' => $this->netAmount,
            'vatAmount' => $this->vatAmount,
            'grossAmount' => $this->grossAmount,
            'description' => $this->description,
            'comment' => $this->comment,
            'vatType' => $this->vatType,
            'productUrl' => $this->productUrl,
            'incomeAccount' => $this->incomeAccount,
      ];
    }
}
