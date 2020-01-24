<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\Account;
use audunru\FikenClient\Tests\TestCase;
use Illuminate\Support\Collection;

class AccountTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_retrieve_accounts()
    {
        $client = new FikenClient();

        $client->authenticate($_ENV['FIKEN_TEST_USERNAME'], $_ENV['FIKEN_TEST_PASSWORD']);
        $company = $client->setCompany($_ENV['FIKEN_TEST_ORGANIZATION_NUMBER']);

        $accounts = $company->accounts(2019);
        $account = $accounts->first();

        $this->assertInstanceOf(Collection::class, $accounts);
        $this->assertInstanceOf(Account::class, $account);
    }
}
