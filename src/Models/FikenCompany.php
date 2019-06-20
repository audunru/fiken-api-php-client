<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\FikenClient;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class FikenCompany extends FikenWritableModel
{
    protected static $relationship = 'https://fiken.no/api/v1/rel/companies';

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
     * Get bank accounts.
     *
     * @return Collection
     */
    public function bankAccounts(): ?Collection
    {
        return FikenBankAccount::all($this);
    }

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
     * Get invoices.
     *
     * @return Collection
     */
    public function invoices(): ?Collection
    {
        return FikenInvoice::all($this);
    }

    /**
     * Get credit notes.
     *
     * @return Collection
     */
    public function creditNotes(): ?Collection
    {
        return FikenCreditNote::all($this);
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
     * Get sales.
     *
     * @return Collection
     */
    public function sales(): ?Collection
    {
        return FikenSale::all($this);
    }

    /**
     * Get purchases.
     *
     * @return Collection
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
        $link = $entry['_links'][static::$relationship]['href'];
        $json = $client->getResource($link);

        return collect($json['_embedded'][static::$relationship])->map(function ($data) use ($client) {
            return static::newFromApi($data);
        });
    }
}
