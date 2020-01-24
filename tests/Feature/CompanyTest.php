<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\Company;
use audunru\FikenClient\Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class CompanyTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_retrieve_companies()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));

        $companies = $client->companies();
        $company = $companies->first();

        $this->assertInstanceOf(Collection::class, $companies);
        $this->assertInstanceOf(Company::class, $company);
    }

    /**
     * @group dangerous
     */
    public function test_it_can_set_a_company()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));
        $this->assertInstanceOf(Company::class, $company);
        $this->assertEquals(env('FIKEN_TEST_ORGANIZATION_NUMBER'), $company->organizationNumber);
    }
}
