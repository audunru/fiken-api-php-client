<?php

namespace audunru\FikenClient\Exceptions;

class InvalidContentException extends FikenClientException
{
    public function __construct(string $message = '')
    {
        parent::__construct($message, 422);
    }
}
