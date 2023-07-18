<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\FikenBaseModel;
use audunru\FikenClient\Traits\IsWritable;

class Payment extends FikenBaseModel
{
    use IsWritable;

    protected static $relation = 'https://fiken.no/api/v1/rel/payments';

    protected $casts = [
        'amount' => 'integer',
        'date'   => 'date',
    ];

    protected $fillable = [
        'date',
        'amount',
    ];

    /**
     * Set income account.
     */
    public function setAccount(Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    /*
     * Convert the model instance to an array that can be used to create a new resource
     *
     * @return array
     */
    public function toNewResourceArray(): array
    {
        return [
            'date'    => $this->date,
            'account' => $this->account ? $this->account->code : null,
            'amount'  => $this->amount,
        ];
    }
}
