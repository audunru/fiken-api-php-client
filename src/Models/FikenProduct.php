<?php

namespace audunru\FikenClient\Models;

class FikenProduct extends FikenWritableModel
{
    protected static $relationship = 'https://fiken.no/api/v1/rel/products';

    protected $fillable = [
        'name',
        'unitPrice',
        'incomeAccount',
        'vatType',
        'active',
        'productNumber',
    ];

    protected $casts = [
        'unitPrice' => 'integer',
        'active' => 'boolean',
    ];
}
