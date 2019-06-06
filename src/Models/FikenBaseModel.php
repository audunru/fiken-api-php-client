<?php

namespace audunru\FikenClient\Models;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Concerns\GuardsAttributes;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Concerns\HidesAttributes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use JsonSerializable;

abstract class FikenBaseModel implements ArrayAccess, Arrayable, Jsonable, JsonSerializable
{
    use GuardsAttributes,
        HasAttributes,
        HasTimestamps,
        HidesAttributes;

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
     * If payload when posting new source is multipart or not.
     *
     * @var bool
     */
    protected static $multipart = false;

    /**
     * Fiken API client.
     *
     * @var FikenClient
     */

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';

    /**
     * The Fiken API client.
     *
     * @var FikenClient
     */
    protected $client;

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
        $this->client = App::make('audunru\FikenClient\FikenClient');
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
     * Create a new instance of the given model.
     *
     * @param array $attributes
     *
     * @return static
     */
    public static function newInstance(array $attributes = [])
    {
        // This method just provides a convenient way for us to generate fresh model
        // instances of this current model. It is particularly useful during the
        // hydration of new objects via the Eloquent query builder instances.
        $model = new static((array) $attributes);

        return $model;
    }

    /**
     * Load an existing model.
     *
     * @param string $link
     *
     * @return static
     */
    public static function load(string $link)
    {
        $client = App::make('audunru\FikenClient\FikenClient');
        $json = $client->getResource($link);

        return static::newFromApi($json);
    }

    /**
     * Save the model.
     *
     * @param FikenBaseModel $parent
     *
     * @return FikenBaseModel
     */
    public function save(FikenBaseModel $parent = null): FikenBaseModel
    {
        $link = $parent ? $parent->getLinkToRelationship(static::$service ?? static::$relationship) : $this->getLinkToSelf();

        $location = $this->client->postToResource($link, $this->toNewResourceArray(), static::$multipart);

        return static::load($location);
    }

    /**
     * Add a child model.
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
     * Create a new model instance that is existing.
     *
     * @param array $attributes
     *
     * @return static
     */
    public static function newFromApi($attributes = [])
    {
        $model = static::newInstance([], true);
        $model->setRawAttributes((array) $attributes);

        return $model;
    }

    /**
     * Get all the models from the API.
     *
     * @param FikenBaseModel $parent
     * @param array          $replace
     *
     * @return Collection
     */
    public static function all(FikenBaseModel $parent, array $replace = []): Collection
    {
        $client = App::make('audunru\FikenClient\FikenClient');
        $link = $parent->getLinkToRelationship(static::$relationship);

        collect($replace)->each(function ($to, $from) use (&$link) {
            $link = str_replace($from, $to, $link);
        });
        $json = $client->getResource($link);

        return collect($json['_embedded'][static::$relationship])->map(function ($data) use ($client) {
            return static::newFromApi($data);
        });
    }

    /**
     * Get a link to a resource this model has a relationship with.
     *
     * @param string $relationship
     *
     * @return string
     */
    public function getLinkToRelationship(string $relationship): string
    {
        return $this->attributes['_links'][$relationship]['href'];
    }

    /**
     * Get the link to this models resource.
     *
     * @return string
     */
    public function getLinkToSelf(): string
    {
        return $this->getLinkToRelationship('self');
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
        // First we will check for the presence of a mutator for the set operation
        // which simply lets the developers tweak the attribute as it is set on
        // the model, such as "json_encoding" an listing of data for storage.
        if ($this->hasSetMutator($key)) {
            return $this->setMutatedAttributeValue($key, $value);
        }
        // If an attribute is listed as a "date", we'll convert it from a DateTime
        // instance into a form proper for storage on the database tables using
        // the connection grammar's date format. We will auto set the values.
        elseif ($value && $this->isDateAttribute($key)) {
            $value = $this->fromDateTime($value);
        }
        if ($this->isJsonCastable($key) && ! is_null($value)) {
            $value = $this->castAttributeAsJson($key, $value);
        }
        // If this attribute contains a JSON ->, we'll set the proper value in the
        // attribute's underlying array. This takes care of properly nesting an
        // attribute in the array's value in the case of deeply nested items.
        if (Str::contains($key, '->')) {
            return $this->fillJsonAttribute($key, $value);
        }
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

    /**
     * Convert the model instance to an array that can be used to create a new resource.
     *
     * @return array
     */
    public function toNewResourceArray()
    {
        return $this->toArray();
    }

    /**
     * Convert the model instance to JSON.
     *
     * @param int $options
     *
     * @throws Exception
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \Exception(json_last_error_msg());
        }

        return $json;
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the model to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return ! is_null($this->getAttribute($offset));
    }

    /**
     * Get the value for a given offset.
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    /**
     * Set the value for a given offset.
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->setAttribute($offset, $value);
    }

    /**
     * Unset the value for a given offset.
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    /**
     * Determine if an attribute or relation exists on the model.
     *
     * @param string $key
     *
     * @return bool
     */
    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Unset an attribute on the model.
     *
     * @param string $key
     */
    public function __unset($key)
    {
        $this->offsetUnset($key);
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return $this->incrementing;
    }

    /**
     * Set whether IDs are incrementing.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function setIncrementing($value)
    {
        $this->incrementing = $value;

        return $this;
    }
}
