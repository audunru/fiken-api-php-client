<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\FikenBaseModel;
use audunru\FikenClient\Traits\IsWritable;

class Contact extends FikenBaseModel
{
    use IsWritable;

    protected static $relation = 'https://fiken.no/api/v1/rel/contacts';

    protected $fillable = [
        'name',
        'email',
        'organizationIdentifier',
        'address',
        'phoneNumber',
        'customer',
        'supplier',
        'currency',
        'memberNumber',
        'language',
    ];

    protected $casts = [
        'customerNumber' => 'integer',
        'customer' => 'boolean',
        'supplierNumber' => 'integer',
        'supplier' => 'boolean',
        'memberNumber' => 'integer',
    ];
}
