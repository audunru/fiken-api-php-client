<?php

namespace audunru\FikenClient\Traits;

use audunru\FikenClient\FikenClient;

trait IsWritable
{
    /**
     * Save this resource.
     */
    public function save(): self
    {
        $client = new FikenClient();
        if (true === $this->exists) {
            $link = $this->getLinkToSelf();
            $location = $client->updateResource($link, $this->toNewResourceArray(), $this->multipart);
        } else {
            $link = $this->service ?? $this->relation;
            $location = $client->createResource($link, $this->toNewResourceArray(), $this->multipart);
        }

        return $this->load($location);
    }

    /**
     * Update the model in the database.
     */
    public function update(array $attributes = []): self
    {
        if (! $this->exists) {
            return false;
        }

        return $this->fill($attributes)->save();
    }
}
