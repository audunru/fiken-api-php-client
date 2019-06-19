<?php

namespace audunru\FikenClient\Models;

use Illuminate\Support\Collection;

class FikenSale extends FikenWritableModel
{
    protected static $relationship = 'https://fiken.no/api/v1/rel/sales';

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
}
