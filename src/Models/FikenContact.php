<?php

namespace audunru\FikenClient\Models;

class FikenContact extends FikenWritableModel
{
    protected static $relationship = 'https://fiken.no/api/v1/rel/contacts';

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
