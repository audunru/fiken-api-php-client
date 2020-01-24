<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\Payment;
use audunru\FikenClient\Models\Purchase;
use audunru\FikenClient\Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class PurchaseTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_retrieve_purchases()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

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
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $purchases = $company->purchases();
        $purchase = $purchases->first();
        $payments = $purchase->payments();
        $payment = $payments->first();

        $this->assertInstanceOf(Collection::class, $payments);
        $this->assertInstanceOf(Payment::class, $payment);
    }
}
