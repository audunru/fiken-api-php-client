<?php

namespace audunru\FikenClient\Exceptions;

class AuthenticationFailedException extends FikenClientException
{
    public function __construct(string $message = '')
    {
        parent::__construct($message, 401);
    }
}
