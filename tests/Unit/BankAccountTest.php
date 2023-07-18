<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\BankAccount;
use audunru\FikenClient\Tests\TestCase;

class BankAccountTest extends TestCase
{
    public function testItCreatesABankAccount()
    {
        $bankAccount = new BankAccount([
            'name'              => 'Bank of Alaska',
            'bankAccountNumber' => '900900900',
            'notFillable'       => 'The thing that should not be',
        ]);

        $this->assertInstanceOf(
            BankAccount::class,
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
        $this->assertNull(
            $bankAccount->notFillable
        );
    }

    public function testItChecksThatNewResourceDoesNotHaveLinkToSelf()
    {
        $bankAccount = new BankAccount();
        $this->assertNull($bankAccount->getLinkToSelf());
    }

    public function testItChecksThatNewResourceDoesNotHaveRelationLink()
    {
        $bankAccount = new BankAccount();
        $this->assertNull($bankAccount->getLinkToRelation('https://fiken.no/api/v1/rel/some-type-of-resource'));
    }
}
