<?php

namespace audunru\FikenClient\Models;

class FikenPayment extends FikenWritableModel
{
    protected static $relationship = 'https://fiken.no/api/v1/rel/payments';
}
