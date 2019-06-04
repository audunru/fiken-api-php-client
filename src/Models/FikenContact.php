<?php

namespace audunru\FikenClient\Models;

class FikenContact extends FikenBaseModel
{
    protected static $rel = 'https://fiken.no/api/v1/rel/contacts';
    protected $fillable = [
        'name',
        'customerNumber',
        'supplierNumber',
        '_links',
    ];
}
