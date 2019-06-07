<?php

namespace audunru\FikenClient\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class FikenCompany extends FikenWritableModel
{
    protected static $relationship = 'https://fiken.no/api/v1/rel/companies';

    /**
     * Get contacts.
     *
     * @return Collection
     */
    public function contacts(): ?Collection
    {
        return FikenContact::all($this);
    }

    /**
     * Get bank accounts.
     *
     * @return Collection
     */
    public function bankAccounts(): ?Collection
    {
        return FikenBankAccount::all($this);
    }

    /**
     * Get products.
     *
     * @return Collection
     */
    public function products(): ?Collection
    {
        return FikenProduct::all($this);
    }

    /**
     * Get accounts.
     *
     * @param int $year
     *
     * @return Collection
     */
    public function accounts(int $year): ?Collection
    {
        return FikenAccount::all($this, ['{year}' => $year]);
    }

    /**
     * Get all of the models from the database.
     *
     * @param array $replace
     *
     * @return Collection
     */
    public static function all(FikenBaseModel $parent = null, array $replace = null): Collection
    {
        $client = App::make('audunru\FikenClient\FikenClient');
        $entry = $client->getResource();
        $link = $entry['_links'][static::$relationship]['href'];
        $json = $client->getResource($link);

        return collect($json['_embedded'][static::$relationship])->map(function ($data) use ($client) {
            return static::newFromApi($data);
        });
    }
}
