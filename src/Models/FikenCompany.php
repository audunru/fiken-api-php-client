<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Traits\HasChildren;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class FikenCompany extends FikenBaseModel
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
        return FikenAccount::all($this, ['{year}' => $year]);
    }

    /**
     * Get bank accounts.
     *
     * @return Collection|null
     */
    public function bankAccounts(): ?Collection
    {
        return FikenBankAccount::all($this);
    }

    /**
     * Get contacts.
     *
     * @return Collection|null
     */
    public function contacts(): ?Collection
    {
        return FikenContact::all($this);
    }

    /**
     * Get invoices.
     *
     * @return Collection|null
     */
    public function invoices(): ?Collection
    {
        return FikenInvoice::all($this);
    }

    /**
     * Get credit notes.
     *
     * @return Collection|null
     */
    public function creditNotes(): ?Collection
    {
        return FikenCreditNote::all($this);
    }

    /**
     * Get products.
     *
     * @return Collection|null
     */
    public function products(): ?Collection
    {
        return FikenProduct::all($this);
    }

    /**
     * Get sales.
     *
     * @return Collection|null
     */
    public function sales(): ?Collection
    {
        return FikenSale::all($this);
    }

    /**
     * Get purchases.
     *
     * @return Collection|null
     */
    public function purchases(): ?Collection
    {
        return FikenPurchase::all($this);
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

        return collect($json['_embedded'][static::$relation])->map(function ($data) use ($client) {
            return static::newFromApi($data);
        });
    }
}
