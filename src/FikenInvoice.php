<?php

namespace audunru\FikenClient;

use Carbon\Carbon;

class FikenInvoice
{
    private $issueDate;
    private $dueDate;
    private $lines;
    private $customer;
    private $bankAccountUrl;
    private $cash;
    private $paymentAccount;

    public function __construct()
    {
        $this->cash = false;
        $this->paymentAccount = null;
    }

    public function issueDate(Carbon $issueDate)
    {
        $this->issueDate = $issueDate;

        return $this;
    }

    public function dueDate(Carbon $dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function customer(FikenCustomer $customer)
    {
        $this->customer = $customer->get();

        return $this;
    }

    public function bankAccountUrl(string $bankAccountUrl)
    {
        $this->bankAccountUrl = $bankAccountUrl;

        return $this;
    }

    public function addLine(FikenInvoiceLine $line)
    {
        $this->lines[] = $line->get();

        return $this;
    }

    public function get()
    {
        return [
            'issueDate' => $this->issueDate->format('Y-m-d'),
            'dueDate' => $this->dueDate->format('Y-m-d'),
            'customer' => $this->customer,
            'bankAccountUrl' => $this->bankAccountUrl,
            'lines' => $this->lines,
        ];
    }
}
