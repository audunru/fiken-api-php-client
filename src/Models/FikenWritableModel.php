<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\FikenClient;
use Illuminate\Support\Facades\App;

abstract class FikenWritableModel extends FikenBaseModel
{
    /**
     * Relationship link.
     *
     * @var string
     */
    protected static $relationship;

    /**
     * Service link.
     *
     * @var string
     */
    protected static $service;

    /**
     * If payload when creating a new resource is multipart (i.e. file upload) or not.
     *
     * @var bool
     */
    protected static $multipart = false;

    /**
     * Save this resource.
     *
     * @param FikenBaseModel $parent
     *
     * @return FikenBaseModel|null
     */
    public function save(FikenWritableModel $parent = null): ?FikenBaseModel
    {
        $link = $parent ? $parent->getLinkToRelationship(static::$service ?? static::$relationship) : $this->getLinkToSelf();
        $client = App::make(FikenClient::class);
        // TODO: Refactor this along with updateResource and createResource
        if ($this->exists) {
            $response = $client->updateResource($link, $this->toNewResourceArray(), static::$multipart);

            return $response;
        } else {
            $location = $client->createResource($link, $this->toNewResourceArray(), static::$multipart);

            return static::load($location);
        }
    }

    /**
     * Create a new resource as a child.
     *
     * @param FikenBaseModel $child
     *
     * @return FikenBaseModel
     */
    public function add(FikenBaseModel $child): FikenBaseModel
    {
        return $child->save($this);
    }

    /**
     * Update the model in the database.
     *
     * @param array $attributes
     * @param array $options
     *
     * @return bool
     */
    public function update(array $attributes = [])
    {
        if (! $this->exists) {
            return false;
        }

        return $this->fill($attributes)->save();
    }
}
