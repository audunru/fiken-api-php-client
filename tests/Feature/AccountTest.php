<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\Models\Account;
use audunru\FikenClient\Tests\ClientTestCase;
use Illuminate\Support\Collection;

class AccountTest extends ClientTestCase
{
    /**
     * @group dangerous
     */
    public function testItCanRetrieveAccounts()
    {
        $accounts = $this->company->accounts(2019);
        $account = $accounts->first();

        $this->assertInstanceOf(Collection::class, $accounts);
        $this->assertInstanceOf(Account::class, $account);
    }
}
