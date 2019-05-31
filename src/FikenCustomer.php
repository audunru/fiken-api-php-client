<?php

namespace audunru\FikenClient;

class FikenCustomer
{
    private $url;

    public function __construct()
    {
    }

    public function url(string $url)
    {
        $this->url = $url;

        return $this;
    }

    public function get()
    {
        return [
            'url' => $this->url,
      ];
    }
}
