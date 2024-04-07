<?php

namespace audunru\FikenClient\Traits;

use Illuminate\Support\Collection;

trait HasLinks
{
    /**
     * Get embedded resources.
     */
    public function getEmbeddedResources(string $relation): ?Collection
    {
        return $this->_embedded[$relation] ? collect($this->_embedded[$relation]) : null;
    }

    /**
     * Get a link to a resource this model has a relation with.
     */
    public function getLinkToRelation(string $relation): ?string
    {
        return $this->_links[$relation]['href'] ?? null;
    }

    /**
     * Get the link to this models resource.
     */
    public function getLinkToSelf(): ?string
    {
        return $this->getLinkToRelation('self');
    }

    /**
     * Get this model's service.
     */
    public static function getService(): ?string
    {
        return static::$service;
    }

    /**
     * Get this model's relation.
     */
    public static function getRelation(): ?string
    {
        return static::$relation;
    }

    /**
     * Get the multipart setting.
     */
    public static function isMultipart(): bool
    {
        return static::$multipart;
    }
}
