<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\Traits\IsWritable;
use Illuminate\Support\Collection;

class FikenPurchase extends FikenBaseModel
{
    use IsWritable;

    protected static $relation = 'https://fiken.no/api/v1/rel/purchases';

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
        return $this->getEmbeddedResources(FikenPayment::getRelation())->map(function ($resource) {
            return FikenPayment::newFromApi($resource);
        });
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
