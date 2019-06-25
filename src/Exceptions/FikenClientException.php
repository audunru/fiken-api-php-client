<?php

namespace audunru\FikenClient\Exceptions;

use Exception;

class FikenClientException extends Exception
{
    protected $error = [];

    public function __construct(string $json = '', int $code = 0)
    {
        $this->error = json_decode($json, true)[0];

        parent::__construct($json, $code);
    }

    public function __toString(): string
    {
        return $this->error['message'];
    }
}
