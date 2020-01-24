<?php

namespace audunru\FikenClient\Traits;

use Illuminate\Support\Collection;

trait HasLinks
{
    /**
     * Get embedded resources.
     *
     * @param string $relation
     *
     * @return Collection|null
     */
    public function getEmbeddedResources(string $relation): ?Collection
    {
        return $this->_embedded[$relation] ? collect($this->_embedded[$relation]) : null;
    }

    /**
     * Get a link to a resource this model has a relation with.
     *
     * @param string $relation
     *
     * @return string|null
     */
    public function getLinkToRelation(string $relation): ?string
    {
        return $this->_links[$relation]['href'] ?? null;
    }

    /**
     * Get the link to this models resource.
     *
     * @return string
     */
    public function getLinkToSelf(): ?string
    {
        return $this->getLinkToRelation('self');
    }

    /**
     * Get this model's service.
     *
     * @return string
     */
    public static function getService(): ?string
    {
        return static::$service;
    }

    /**
     * Get this model's relation.
     *
     * @return string
     */
    public static function getRelation(): ?string
    {
        return static::$relation;
    }

    /**
     * Get the multipart setting.
     *
     * @return bool
     */
    public static function isMultipart(): bool
    {
        return static::$multipart;
    }
}
