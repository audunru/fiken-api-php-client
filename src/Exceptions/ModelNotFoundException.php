<?php

namespace audunru\FikenClient\Exceptions;

class ModelNotFoundException extends FikenClientException
{
    public function __construct(string $message = '')
    {
        parent::__construct($message, 404);
    }
}
