<?php

namespace audunru\FikenClient\Traits;

trait HasHalLinks
{
    /**
     * Get a link to a resource this model has a relationship with.
     *
     * @param string $relationship
     *
     * @return string
     */
    public function getLinkToRelationship(string $relationship): ?string
    {
        return $this->attributes['_links'][$relationship]['href'] ?? null;
    }

    /**
     * Get the link to this models resource.
     *
     * @return string
     */
    public function getLinkToSelf(): ?string
    {
        return $this->getLinkToRelationship('self');
    }
}
