<?php

namespace audunru\FikenClient\Models;

class FikenProduct extends FikenBaseModel
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
}
