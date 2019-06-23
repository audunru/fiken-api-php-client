<?php

namespace audunru\FikenClient\Models;

use Illuminate\Support\Collection;

class FikenInvoice extends FikenWritableModel
{
    protected static $relationship = 'https://fiken.no/api/v1/rel/invoices';

    protected static $service = 'https://fiken.no/api/v1/rel/create-invoice-service';

    protected $fillable = [
        'issueDate',
        'dueDate',
        'invoiceText',
    ];

    protected $dates = [
        'issueDate',
        'dueDate',
    ];

    /**
     * Get sale.
     *
     * @return FikenSale
     */
    public function sale(): ?FikenSale
    {
        return FikenSale::load($this->sale);
    }

    /**
     * Get customer.
     *
     * @return FikenContact
     */
    public function customer(): ?FikenContact
    {
        return FikenContact::load($this->customer);
    }

    /**
     * Get invoice lines.
     *
     * @return Collection
     */
    public function lines(): ?Collection
    {
        return collect($this->lines)->map(function ($line) {
            return FikenInvoiceLine::newFromApi($line);
        });
    }

    /**
     * Set customer.
     *
     * @param FikenContact $customer
     *
     * @return FikenInvoice
     */
    public function setCustomer(FikenContact $customer): FikenInvoice
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
    public function setBankAccount(FikenBankAccount $bankAccount): FikenInvoice
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

    /**
     * Add invoice line.
     *
     * @param FikenBaseModel $line
     *
     * @return FikenInvoice
     */
    public function add(FikenBaseModel $line): FikenBaseModel
    {
        if ($line instanceof FikenInvoiceLine) {
            $this->attributes['lines'][] = $line->toNewResourceArray();

            return $this;
        } else {
            return parent::add($line);
        }
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
        ];
    }
}
