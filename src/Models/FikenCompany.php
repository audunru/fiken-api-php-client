<?php

namespace audunru\FikenClient\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

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
        return FikenContact::all();
    }

    public function bankAccounts(): Collection
    {
        return FikenBankAccount::all();
    }

    public function products(): Collection
    {
        return FikenProduct::all();
    }

    public function accounts(int $year): Collection
    {
        return FikenAccount::all(['{year}' => $year]);
    }

    /**
     * Get all of the models from the database.
     */
    public static function all(array $replace = null): Collection
    {
        $client = App::make('audunru\FikenClient\FikenClient');
        $entry = $client->get();
        $link = $entry['_links'][static::$rel]['href'];
        $json = $client->get($link);

        return collect($json['_embedded'][static::$rel])->map(function ($data) use ($client) {
            return new static($data, $client);
        });
    }
}
