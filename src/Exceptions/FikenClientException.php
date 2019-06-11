<?php

namespace audunru\FikenClient\Exceptions;

use Exception;

class FikenClientException extends Exception
{
    public function __construct(string $message = '', int $code = 0)
    {
        parent::__construct($message, $code);
    }
}
