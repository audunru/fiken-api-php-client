<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Traits\GuardsAttributes;
use audunru\FikenClient\Traits\HasAttributes;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

abstract class FikenBaseModel implements Arrayable
{
    use GuardsAttributes, HasAttributes;

    protected static $rel;
    protected $client;

    public function __construct(array $attributes = [], FikenClient $client = null)
    {
        $this->fill($attributes);
        $this->client = $client;
    }

    /*
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            // The developers may choose to place some attributes in the "fillable" array
            // which means only those attributes may be set through mass assignment to
            // the model, and all others will just get ignored for security reasons.
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            }
        }

        return $this;
    }

    /**
     * Get all of the models from the database.
     */
    public static function all(FikenClient $client): Collection
    {
        $link = $client->company->getRelationshipLink(static::$rel);
        $json = $client->get($link);

        return collect($json['_embedded'][static::$rel])->map(function ($data) use ($client) {
            return new static($data, $client);
        });
    }

    /**
     * Filter items by the given key value pair.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return static
     */
    public static function where($key, $value, FikenClient $client): Collection
    {
        return static::all($client)->filter(function ($item) use ($key, $value) {
            return $item->$key == $value;
        });
    }

    public function getRelationshipLink(string $rel)
    {
        return $this->attributes['_links'][$rel]['href'];
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Get an attribute from the model.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (! $key) {
            return;
        }
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    /**
     * Set a given attribute on the model.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributesToArray();
    }
}
