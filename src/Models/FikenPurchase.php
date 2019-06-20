<?php

namespace audunru\FikenClient\Models;

use Illuminate\Support\Collection;

class FikenPurchase extends FikenWritableModel
{
    protected static $relationship = 'https://fiken.no/api/v1/rel/purchases';

    protected $dates = [
        'date',
    ];

    protected $dateFormat = 'Y-m-d';

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
}
