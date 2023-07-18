<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\Account;
use audunru\FikenClient\Tests\TestCase;

class AccountTest extends TestCase
{
    public function testItCreatesAnAccount()
    {
        $account = new Account();

        $this->assertInstanceOf(
            Account::class,
            $account
        );
    }
}
