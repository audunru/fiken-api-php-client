<?php

namespace audunru\FikenClient;

use audunru\FikenClient\Models\FikenCompany;
use audunru\FikenClient\Traits\ConnectsToFiken;
use Illuminate\Support\Collection;

class FikenClient
{
    use ConnectsToFiken;

    public $company;

    public function company(string $organizationNumber): FikenCompany
    {
        $this->company = $this->companies()->firstWhere('organizationNumber', $organizationNumber);

        return $this->company;
    }

    public function user(): array
    {
        return $this->getResource('whoAmI');
    }

    public function companies(): Collection
    {
        return FikenCompany::all();
    }
}
