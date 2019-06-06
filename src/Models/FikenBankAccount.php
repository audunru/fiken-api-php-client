<?php

namespace audunru\FikenClient\Models;

class FikenBankAccount extends FikenBaseModel
{
    protected static $relationship = 'https://fiken.no/api/v1/rel/bank-accounts';

    protected $fillable = [
        'name',
        'number',
        'bankAccountNumber',
    ];
}
