<?php

namespace audunru\FikenClient\Models;

use Illuminate\Support\Collection;

class FikenPurchase extends FikenWritableModel
{
    protected static $relationship = 'https://fiken.no/api/v1/rel/purchases';

    protected $dates = [
        'date',
    ];

    protected $casts = [
        'paid' => 'boolean',
    ];

    /**
     * Get payments.
     *
     * @return Collection|null
     */
    public function payments(): ?Collection
    {
        return FikenPayment::all($this);
    }

    /**
     * Get attachments.
     *
     * @return Collection|null
     */
    public function attachments(): ?Collection
    {
        return FikenAttachment::all($this);
    }
}
