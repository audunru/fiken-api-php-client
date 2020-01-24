<?php

namespace audunru\FikenClient\Traits;

use audunru\FikenClient\FikenBaseModel;
use audunru\FikenClient\FikenClient;

trait HasChildren
{
    /**
     * Create a new resource as a child.
     */
    public function add(FikenBaseModel $child): FikenBaseModel
    {
        $link = $this->getLinkToRelation($child->getService() ?? $child->getRelation());
        $client = new FikenClient();
        $location = $client->createResource($link, $child->toNewResourceArray(), $child->isMultipart());

        return $child::load($location);
    }
}
