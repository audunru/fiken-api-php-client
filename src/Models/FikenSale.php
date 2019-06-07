<?php

namespace audunru\FikenClient\Models;

use Illuminate\Support\Collection;

class FikenSale extends FikenWritableModel
{
    protected static $relationship = 'https://fiken.no/api/v1/rel/sales';

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
