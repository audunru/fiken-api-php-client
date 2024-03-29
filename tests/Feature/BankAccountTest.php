<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\Models\BankAccount;
use audunru\FikenClient\Tests\ClientTestCase;
use Illuminate\Support\Collection;

class BankAccountTest extends ClientTestCase
{
    /**
     * @group dangerous
     */
    public function testItCanRetrieveBankAccounts()
    {
        $bankAccounts = $this->company->bankAccounts();
        $bankAccount = $bankAccounts->first();

        $this->assertInstanceOf(Collection::class, $bankAccounts);
        $this->assertInstanceOf(BankAccount::class, $bankAccount);
    }
}
