<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\FikenBaseModel;
use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Traits\HasChildren;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class Company extends FikenBaseModel
{
    use HasChildren;

    protected static $relation = 'https://fiken.no/api/v1/rel/companies';

    /**
     * Get accounts.
     *
     * @param int $year
     *
     * @return Collection|null
     */
    public function accounts(int $year): ?Collection
    {
        return Account::all($this, ['{year}' => $year]);
    }

    /**
     * Get bank accounts.
     *
     * @return Collection|null
     */
    public function bankAccounts(): ?Collection
    {
        return BankAccount::all($this);
    }

    /**
     * Get contacts.
     *
     * @return Collection|null
     */
    public function contacts(): ?Collection
    {
        return Contact::all($this);
    }

    /**
     * Get invoices.
     *
     * @return Collection|null
     */
    public function invoices(): ?Collection
    {
        return Invoice::all($this);
    }

    /**
     * Get credit notes.
     *
     * @return Collection|null
     */
    public function creditNotes(): ?Collection
    {
        return CreditNote::all($this);
    }

    /**
     * Get products.
     *
     * @return Collection|null
     */
    public function products(): ?Collection
    {
        return Product::all($this);
    }

    /**
     * Get sales.
     *
     * @return Collection|null
     */
    public function sales(): ?Collection
    {
        return Sale::all($this);
    }

    /**
     * Get purchases.
     *
     * @return Collection|null
     */
    public function purchases(): ?Collection
    {
        return Purchase::all($this);
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
        $client = App::make(FikenClient::class);
        $entry = $client->getResource();
        $link = $entry['_links'][static::$relation]['href'];
        $json = $client->getResource($link);

        return collect($json['_embedded'][static::$relation])->map(function ($data) {
            return static::newFromApi($data);
        });
    }
}
