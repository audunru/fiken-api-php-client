<?php

namespace audunru\FikenClient\Exceptions;

use Exception;

class FikenClientException extends Exception
{
    protected $error = [];

    public function __construct(string $message = '', int $code = 0)
    {
        $this->error = json_decode($message, true)[0];

        parent::__construct($message, $code);
    }

    public function __toString(): string
    {
        return $this->error['message'];
    }
}
