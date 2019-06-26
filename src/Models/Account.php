<?php

namespace audunru\FikenClient\Models;

use audunru\FikenClient\FikenBaseModel;

class Account extends FikenBaseModel
{
    protected static $relation = 'https://fiken.no/api/v1/rel/accounts';
}
