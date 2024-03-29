<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\Models\CashSale;
use audunru\FikenClient\Models\InvoiceLine;
use audunru\FikenClient\Tests\ClientTestCase;
use Carbon\Carbon;

class CashSaleTest extends ClientTestCase
{
    /**
     * @group dangerous
     */
    public function testItCanCreateACashSale()
    {
        $cashSale = new CashSale([
            'issueDate'   => Carbon::now(),
            'dueDate'     => Carbon::now(),
            'invoiceText' => 'Payment for import/export services', ]
        );
        $customer = $this->company->contacts()->first();
        $bankAccount = $this->company->bankAccounts()->first();
        $paymentAccount = $this->company->accounts(2019)->firstWhere('code', '1920:10001');

        $cashSale
          ->setCustomer($customer)
          ->setBankAccount($bankAccount)
          ->setPaymentAccount($paymentAccount);

        $product = $this->company->products()->firstWhere('vatType', 'HIGH');
        $line = new InvoiceLine([
            'netAmount'   => 8000,
            'vatAmount'   => 2000,
            'grossAmount' => 10000,
            'comment'     => 'Chips',
        ]);
        $line->setProduct($product);
        $cashSale->add($line);

        $saved = $this->company->add($cashSale);

        $this->assertInstanceOf(CashSale::class, $saved);
        $this->assertEquals('Payment for import/export services', $saved->invoiceText);
        $this->assertEquals(8000, $saved->netInNok);
        $this->assertEquals(2000, $saved->vatInNok);
        $this->assertEquals(10000, $saved->grossInNok);
    }
}
