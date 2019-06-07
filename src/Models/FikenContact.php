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
        'customer' => 'boolean',
        'supplier' => 'boolean',
        'memberNumber' => 'integer',
    ];
}
