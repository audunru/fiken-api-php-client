<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\FikenClient;
use Illuminate\Support\Collection;

class FikenCompany extends FikenBaseModel
{
    protected static $rel = 'https://fiken.no/api/v1/rel/companies';
    protected $fillable = [
        'name',
        'organizationNumber',
        '_links',
    ];

    public function contacts(): Collection
    {
        return FikenContact::all($this->client);
    }

    public function bankAccounts(): Collection
    {
        return FikenBankAccount::all($this->client);
    }

    public function products(): Collection
    {
        return FikenProduct::all($this->client);
    }

    public function accounts(): Collection
    {
        return FikenAccount::all($this->client);
    }

    /**
     * Get all of the models from the database.
     */
    public static function all(FikenClient $client): Collection
    {
        $entry = $client->get();
        $link = $entry['_links'][static::$rel]['href'];
        $json = $client->get($link);

        return collect($json['_embedded'][static::$rel])->map(function ($data) use ($client) {
            return new static($data, $client);
        });
    }
}
