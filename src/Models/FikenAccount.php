<?php

namespace audunru\FikenClient\Models;

class FikenAccount extends FikenBaseModel
{
    protected static $rel = 'https://fiken.no/api/v1/rel/accounts';
    protected $fillable = [
        'name',
        'code',
        '_links',
    ];
}
