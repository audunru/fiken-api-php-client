<?php

namespace audunru\FikenClient\Models;

class FikenBankAccount extends FikenWritableModel
{
    protected static $relationship = 'https://fiken.no/api/v1/rel/bank-accounts';

    protected $fillable = [
        'name',
        'bankAccountNumber',
    ];
}
