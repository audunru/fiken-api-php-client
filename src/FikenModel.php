<?php

namespace audunru\FikenClient;

abstract class FikenModel
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getLink($type)
    {
        return $this->data['_links'][$type]['href'];
    }

    public function link()
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
