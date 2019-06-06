<?php

namespace audunru\FikenClient\Models;

use Illuminate\Support\Collection;

class FikenSale extends FikenBaseModel
{
    protected static $relationship = 'https://fiken.no/api/v1/rel/sales';

    /**
     * Get attachments.
     *
     * @return Collection
     */
    public function attachments(): Collection
    {
        return FikenAttachment::all($this);
    }

    /**
     * Add an attachment to the sale.
     *
     * @param FikenAttachment $attachment
     *
     * @return string
     */
    public function addAttachment(FikenAttachment $attachment): string
    {
        $link = $this->getLinkToRelationship('https://fiken.no/api/v1/rel/attachments');

        return $this->client->postToResource($link, $attachment->toNewResourceArray(), true);
    }
}
