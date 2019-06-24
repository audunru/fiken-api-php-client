<?php

namespace audunru\FikenClient\Traits;

trait HasHalLinks
{
    /**
     * Get embedded resources.
     *
     * @param string $relationship
     *
     * @return array|null
     */
    public function getEmbeddedResources(string $relationship): ?array
    {
        return $this->_embedded[$relationship] ?? null;
    }

    /**
     * Get a link to a resource this model has a relationship with.
     *
     * @param string $relationship
     *
     * @return string|null
     */
    public function getLinkToRelationship(string $relationship): ?string
    {
        return $this->_links[$relationship]['href'] ?? null;
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
