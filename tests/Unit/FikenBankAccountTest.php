<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\FikenBankAccount;
use audunru\FikenClient\Tests\TestCase;

class FikenBankAccountTest extends TestCase
{
    public function test_it_creates_a_bank_account()
    {
        $bankAccount = new FikenBankAccount([
            'name' => 'Bank of Alaska',
            'bankAccountNumber' => '900900900',
        ]);

        $this->assertInstanceOf(
            FikenBankAccount::class,
            $bankAccount
        );
        $this->assertEquals(
            'Bank of Alaska',
            $bankAccount->name
        );
        $this->assertEquals(
            '900900900',
            $bankAccount->bankAccountNumber
        );
    }

    public function test_it_checks_that_new_resource_does_not_have_link_to_self()
    {
        $bankAccount = new FikenBankAccount();
        $this->assertNull($bankAccount->getLinkToSelf());
    }

    public function test_it_checks_that_new_resource_does_not_have_relationship_link()
    {
        $bankAccount = new FikenBankAccount();
        $this->assertNull($bankAccount->getLinkToRelationship('https://fiken.no/api/v1/rel/some-type-of-resource'));
    }
}
