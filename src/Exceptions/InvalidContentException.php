<?php

namespace audunru\FikenClient\Exceptions;

class InvalidContentException extends FikenClientException
{
    public function __construct(string $json = '')
    {
        parent::__construct($json, 422);
    }
}
