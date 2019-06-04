<?php

namespace audunru\FikenClient\Models;

class FikenBankAccount extends FikenBaseModel
{
    protected static $rel = 'https://fiken.no/api/v1/rel/bank-accounts';
    protected $fillable = [
      'name',
      'number',
      'bankAccountNumber',
      '_links',
    ];
}
