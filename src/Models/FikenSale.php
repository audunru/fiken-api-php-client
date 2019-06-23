<?php

namespace audunru\FikenClient\Models;

use Illuminate\Support\Collection;

class FikenSale extends FikenWritableModel
{
    protected static $relationship = 'https://fiken.no/api/v1/rel/sales';

    protected $fillable = [
        'date',
        'kind',
        'identifier',
        'paid',
        'dueDate',
        'kid',
        'paymentDate',
    ];

    protected $dates = [
        'date',
        'dueDate',
        'paymentDate',
    ];

    protected $casts = [
        'paid' => 'boolean',
    ];

    /**
     * Get payments.
     *
     * @return Collection
     */
    public function payments(): ?Collection
    {
        return FikenPayment::all($this);
    }

    /**
     * Get attachments.
     *
     * @return Collection
     */
    public function attachments(): ?Collection
    {
        return FikenAttachment::all($this);
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
            return FikenOrderLine::newFromApi($line);
        });
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
        if ($line instanceof FikenOrderLine) {
            $this->attributes['lines'][] = $line->toNewResourceArray();

            return $this;
        } else {
            return parent::add($line);
        }
    }

    /**
     * Set payment account.
     *
     * @param FikenAccount $account
     *
     * @return FikenSale
     */
    public function setPaymentAccount(FikenAccount $account): FikenSale
    {
        $this->paymentAccount = $account;

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
            'date' => $this->date,
            'kind' => $this->kind,
            'identifier' => $this->identifier,
            'paid' => $this->paid,
            'identifier' => $this->identifier,
            'lines' => $this->lines,
            'customer' => $this->customer ? $this->customer->getLinkToSelf() : null,
            'dueDate' => $this->dueDate,
            'kid' => $this->kid,
            'paymentAccount' => $this->paymentAccount ? $this->paymentAccount->code : null,
            'paymentDate' => $this->paymentDate,
        ];
    }
}
