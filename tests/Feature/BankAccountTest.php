<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\BankAccount;
use audunru\FikenClient\Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class BankAccountTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_retrieve_bank_accounts()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $bankAccounts = $company->bankAccounts();
        $bankAccount = $bankAccounts->first();

        $this->assertInstanceOf(Collection::class, $bankAccounts);
        $this->assertInstanceOf(BankAccount::class, $bankAccount);
    }
}
