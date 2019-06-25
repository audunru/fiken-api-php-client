<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\Traits\IsWritable;

class FikenBankAccount extends FikenBaseModel
{
    use IsWritable;

    protected static $relation = 'https://fiken.no/api/v1/rel/bank-accounts';

    protected $fillable = [
        'name',
        'bankAccountNumber',
    ];
}
