<?php

namespace audunru\FikenClient;

abstract class FikenModel
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getLink($type): string
    {
        return $this->data['_links'][$type]['href'];
    }

    public function link(): string
    {
        return $this->getLink('self');
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
    }
}
