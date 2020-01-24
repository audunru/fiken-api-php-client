<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\Payment;
use audunru\FikenClient\Models\Purchase;
use audunru\FikenClient\Tests\TestCase;
use Illuminate\Support\Collection;

class PurchaseTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_retrieve_purchases()
    {
        $client = new FikenClient();

        $client->authenticate($_ENV['FIKEN_TEST_USERNAME'], $_ENV['FIKEN_TEST_PASSWORD']);
        $company = $client->setCompany($_ENV['FIKEN_TEST_ORGANIZATION_NUMBER']);

        $purchases = $company->purchases();
        $purchase = $purchases->first();

        $this->assertInstanceOf(Collection::class, $purchases);
        $this->assertInstanceOf(Purchase::class, $purchase);
    }

    /**
     * @group dangerous
     */
    public function test_purchase_has_payments()
    {
        $client = new FikenClient();

        $client->authenticate($_ENV['FIKEN_TEST_USERNAME'], $_ENV['FIKEN_TEST_PASSWORD']);
        $company = $client->setCompany($_ENV['FIKEN_TEST_ORGANIZATION_NUMBER']);

        $purchases = $company->purchases();
        $purchase = $purchases->first();
        $payments = $purchase->payments();
        $payment = $payments->first();

        $this->assertInstanceOf(Collection::class, $payments);
        $this->assertInstanceOf(Payment::class, $payment);
    }
}
