<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\FikenBaseModel;
use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Traits\HasChildren;
use Illuminate\Support\Collection;

class Company extends FikenBaseModel
{
    use HasChildren;

    protected static $relation = 'https://fiken.no/api/v1/rel/companies';

    /**
     * Get accounts.
     */
    public function accounts(int $year): ?Collection
    {
        return Account::all($this, ['{year}' => $year]);
    }

    /**
     * Get bank accounts.
     */
    public function bankAccounts(): ?Collection
    {
        return BankAccount::all($this);
    }

    /**
     * Get contacts.
     */
    public function contacts(): ?Collection
    {
        return Contact::all($this);
    }

    /**
     * Get invoices.
     */
    public function invoices(): ?Collection
    {
        return Invoice::all($this);
    }

    /**
     * Get credit notes.
     */
    public function creditNotes(): ?Collection
    {
        return CreditNote::all($this);
    }

    /**
     * Get products.
     */
    public function products(): ?Collection
    {
        return Product::all($this);
    }

    /**
     * Get sales.
     */
    public function sales(): ?Collection
    {
        return Sale::all($this);
    }

    /**
     * Get all of the models from the database.
     *
     * @param array $replace
     */
    public static function all(FikenBaseModel $parent = null, array $replace = null): Collection
    {
        $client = new FikenClient();
        $entry = $client->getResource();
        $link = $entry['_links'][static::$relation]['href'];
        $json = $client->getResource($link);

        return collect($json['_embedded'][static::$relation])->map(function ($data) {
            return static::newFromApi($data);
        });
    }
}
