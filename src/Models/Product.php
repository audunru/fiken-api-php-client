<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\FikenBaseModel;
use audunru\FikenClient\Traits\IsWritable;

class Product extends FikenBaseModel
{
    use IsWritable;

    protected static $relation = 'https://fiken.no/api/v1/rel/products';

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
