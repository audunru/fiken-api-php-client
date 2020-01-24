<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\Account;
use audunru\FikenClient\Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class AccountTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_retrieve_accounts()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $accounts = $company->accounts(2019);
        $account = $accounts->first();

        $this->assertInstanceOf(Collection::class, $accounts);
        $this->assertInstanceOf(Account::class, $account);
    }
}
