<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\Traits\IsWritable;

class FikenCreditNote extends FikenBaseModel
{
    use IsWritable;

    protected static $relation = 'https://fiken.no/api/v1/rel/credit-notes';

    protected $casts = [
        'creditNoteNumber' => 'integer',
        'net' => 'integer',
        'vat' => 'integer',
        'gross' => 'integer',
        'netInNok' => 'integer',
        'vatInNok' => 'integer',
        'grossInNok' => 'integer',
    ];

    /**
     * Get customer.
     *
     * @return FikenContact|null
     */
    public function customer(): ?FikenContact
    {
        return FikenContact::load($this->customer);
    }

    /**
     * Get invoice.
     *
     * @return FikenInvoice|null
     */
    public function invoice(): ?FikenInvoice
    {
        return FikenInvoice::load($this->invoice);
    }
}
