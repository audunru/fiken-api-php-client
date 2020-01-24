<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\CashSale;
use audunru\FikenClient\Models\InvoiceLine;
use audunru\FikenClient\Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class CashSaleTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_create_a_cash_sale()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $cashSale = new CashSale([
            'issueDate' => Carbon::now(),
            'dueDate' => Carbon::now(),
            'invoiceText' => 'Payment for import/export services', ]
        );
        $customer = $company->contacts()->first();
        $bankAccount = $company->bankAccounts()->first();
        $paymentAccount = $company->accounts(2019)->firstWhere('code', '1920:10001');

        $cashSale
          ->setCustomer($customer)
          ->setBankAccount($bankAccount)
          ->setPaymentAccount($paymentAccount);

        $product = $company->products()->firstWhere('vatType', 'HIGH');
        $line = new InvoiceLine([
            'netAmount' => 8000,
            'vatAmount' => 2000,
            'grossAmount' => 10000,
            'comment' => 'Chips',
        ]);
        $line->setProduct($product);
        $cashSale->add($line);

        $saved = $company->add($cashSale);

        $this->assertInstanceOf(CashSale::class, $saved);
        $this->assertEquals('Payment for import/export services', $saved->invoiceText);
        $this->assertEquals(8000, $saved->netInNok);
        $this->assertEquals(2000, $saved->vatInNok);
        $this->assertEquals(10000, $saved->grossInNok);
    }
}
