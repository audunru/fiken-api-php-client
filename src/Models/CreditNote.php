<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\FikenBaseModel;
use audunru\FikenClient\Traits\IsWritable;

class CreditNote extends FikenBaseModel
{
    use IsWritable;

    protected static $relation = 'https://fiken.no/api/v1/rel/credit-notes';

    protected $casts = [
        'creditNoteNumber' => 'integer',
        'net'              => 'integer',
        'vat'              => 'integer',
        'gross'            => 'integer',
        'netInNok'         => 'integer',
        'vatInNok'         => 'integer',
        'grossInNok'       => 'integer',
    ];

    /**
     * Get customer.
     */
    public function customer(): ?Contact
    {
        return Contact::load($this->customer);
    }

    /**
     * Get invoice.
     */
    public function invoice(): ?Invoice
    {
        return Invoice::load($this->invoice);
    }
}
