<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\FikenBaseModel;
use audunru\FikenClient\Traits\IsWritable;
use Illuminate\Support\Collection;

class Invoice extends FikenBaseModel
{
    use IsWritable;

    protected static $relation = 'https://fiken.no/api/v1/rel/invoices';

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
     */
    public function sale(): ?Sale
    {
        return Sale::load($this->sale);
    }

    /**
     * Get customer.
     */
    public function customer(): ?Contact
    {
        return Contact::load($this->customer);
    }

    /**
     * Get invoice lines.
     */
    public function lines(): ?Collection
    {
        return collect($this->lines)->map(function ($line) {
            return InvoiceLine::newFromApi($line);
        });
    }

    /**
     * Set customer.
     */
    public function setCustomer(Contact $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Set bank account.
     */
    public function setBankAccount(BankAccount $bankAccount): self
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

    /**
     * Add invoice line.
     *
     * @return Invoice
     */
    public function add(FikenBaseModel $line): FikenBaseModel
    {
        if ($line instanceof InvoiceLine) {
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
            'dueDate'   => $this->dueDate,
            'customer'  => [
                'url' => $this->customer ? $this->customer->getLinkToSelf() : null,
            ],
            'bankAccountUrl' => $this->bankAccount ? $this->bankAccount->getLinkToSelf() : null,
            'invoiceText'    => $this->invoiceText,
            'lines'          => $this->lines,
        ];
    }
}
