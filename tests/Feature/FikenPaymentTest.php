<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\FikenPayment;
use audunru\FikenClient\Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class FikenPaymentTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_add_payment_to_sale()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $sales = $company->sales();
        $sale = $sales->first();

        $payment = new FikenPayment([
          'date' => Carbon::now(),
          'account' => '1920:10001',
          'amount' => 10000,
        ]);

        $saved = $sale->add($payment);

        $this->assertInstanceOf(FikenPayment::class, $saved);
    }

    /*
     * @group dangerous
     */
    // TODO: Getting error from Fiken, perhaps they are not ready yet
/*
    public function test_it_can_add_payment_to_purchase()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $purchases = $company->purchases();
        $purchase = $purchases->first();

        $payment = new FikenPayment([
          'date' => Carbon::now(),
          'account' => '1920:10001',
          'amount' => 10000,
        ]);

        $saved = $purchase->add($payment);

        $this->assertInstanceOf(FikenPayment::class, $saved);
    }*/
}
