<?php

namespace audunru\FikenClient;

use audunru\FikenClient\Models\Company;
use audunru\FikenClient\Models\User;
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
     * @var Company
     */
    protected $company;

    /**
     * Set company by organization number.
     *
     * @param string $organizationNumber
     *
     * @return Company
     */
    public function setCompany(string $organizationNumber): Company
    {
        $this->company = $this->companies()->firstWhere('organizationNumber', $organizationNumber);

        return $this->company;
    }

    /**
     * Get details about current user.
     *
     * @return User
     */
    public function user(): User
    {
        return User::load('https://fiken.no/api/v1/whoAmI');
    }

    /**
     * Get all companies the current user can access.
     *
     * @return Collection
     */
    public function companies(): Collection
    {
        return Company::all();
    }
}
