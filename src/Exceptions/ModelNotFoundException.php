<?php

namespace audunru\FikenClient\Exceptions;

use Exception;

class ModelNotFoundException extends Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message, 404);
    }
}
