<?php

namespace audunru\FikenClient\Traits;

use audunru\FikenClient\FikenBaseModel;
use audunru\FikenClient\FikenClient;
use Illuminate\Support\Facades\App;

trait HasChildren
{
    /**
     * Create a new resource as a child.
     *
     * @param FikenBaseModel $child
     *
     * @return FikenBaseModel
     */
    public function add(FikenBaseModel $child): FikenBaseModel
    {
        $link = $this->getLinkToRelation($child->getService() ?? $child->getRelation());
        $client = App::make(FikenClient::class);
        $location = $client->createResource($link, $child->toNewResourceArray(), $child->isMultipart());

        return $child::load($location);
    }
}
