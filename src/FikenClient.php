<?php

namespace audunru\FikenClient;

use audunru\FikenClient\Models\FikenCompany;
use audunru\FikenClient\Models\FikenUser;
use audunru\FikenClient\Traits\ConnectsToFiken;
use Illuminate\Support\Collection;

class FikenClient
{
    use ConnectsToFiken;

    /**
     * The entry point for all Fiken API requests.
     *
     * @var string
     */
    const BASE_URI = 'https://fiken.no/api/v1/';

    /**
     * The active company.
     *
     * @var FikenCompany
     */
    protected $company;

    /**
     * Set company by organization number.
     *
     * @param string $organizationNumber
     *
     * @return FikenCompany
     */
    public function setCompany(string $organizationNumber): FikenCompany
    {
        $this->company = $this->companies()->firstWhere('organizationNumber', $organizationNumber);

        return $this->company;
    }

    /**
     * Get details about current user.
     *
     * @return FikenUser
     */
    public function user(): FikenUser
    {
        return FikenUser::load('https://fiken.no/api/v1/whoAmI');
    }

    /**
     * Get all companies the current user can access.
     *
     * @return Collection
     */
    public function companies(): Collection
    {
        return FikenCompany::all();
    }
}
