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
     * The active company.
     *
     * @var Company
     */
    protected $company;

    /**
     * Set company by organization number.
     */
    public function setCompany(string $organizationNumber): Company
    {
        $this->company = $this->companies()->firstWhere('organizationNumber', $organizationNumber);

        return $this->company;
    }

    /**
     * Get details about current user.
     */
    public function user(): User
    {
        return User::load('https://fiken.no/api/v1/whoAmI');
    }

    /**
     * Get all companies the current user can access.
     */
    public function companies(): Collection
    {
        return Company::all();
    }
}
