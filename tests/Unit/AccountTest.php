<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\Account;
use audunru\FikenClient\Tests\TestCase;

class AccountTest extends TestCase
{
    public function test_it_creates_an_account()
    {
        $account = new Account();

        $this->assertInstanceOf(
            Account::class,
            $account
        );
    }
}
