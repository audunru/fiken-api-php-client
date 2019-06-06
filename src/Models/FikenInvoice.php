<?php

namespace audunru\FikenClient\Models;

class FikenInvoice extends FikenBaseModel
{
    protected static $relationship = 'https://fiken.no/api/v1/rel/invoices';
    protected static $service = 'https://fiken.no/api/v1/rel/create-invoice-service';

    protected $fillable = [
        'issueDate',
        'dueDate',
    ];

    protected $dates = [
        'issueDate',
        'dueDate',
    ];

    protected $dateFormat = 'Y-m-d';

    /**
     * Set customer.
     *
     * @param FikenContact $customer
     *
     * @return FikenInvoice
     */
    public function customer(FikenContact $customer): FikenInvoice
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Set bank account.
     *
     * @param FikenBankAccount $bankAccount
     *
     * @return FikenInvoice
     */
    public function bankAccount(FikenBankAccount $bankAccount): FikenInvoice
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

    /**
     * Add invoice line.
     *
     * @param FikenInvoiceLine $line
     *
     * @return FikenInvoice
     */
    public function addLine(FikenInvoiceLine $line): FikenInvoice
    {
        $this->attributes['lines'][] = $line->toNewResourceArray();

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
                'url' => is_object($this->customer) ? $this->customer->getLinkToSelf() : $this->customer,
            ],
            'bankAccountUrl' => is_object($this->bankAccount) ? $this->bankAccount->getLinkToSelf() : $this->bankAccountNumber,
            'invoiceText' => $this->invoiceText,
            'lines' => $this->lines,
        ];
    }
}
