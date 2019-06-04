<?php

namespace audunru\FikenClient\Models;

class FikenProduct extends FikenBaseModel
{
    protected static $rel = 'https://fiken.no/api/v1/rel/products';
    protected $fillable = [
        'name',
        'incomeAccount',
        'vatType',
        'active',
        '_links',
    ];
}
