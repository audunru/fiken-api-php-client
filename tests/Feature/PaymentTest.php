<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\Payment;
use audunru\FikenClient\Tests\TestCase;
use Carbon\Carbon;

class PaymentTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_add_payment_to_sale()
    {
        $client = new FikenClient();

        $client->authenticate($_ENV['FIKEN_TEST_USERNAME'], $_ENV['FIKEN_TEST_PASSWORD']);
        $company = $client->setCompany($_ENV['FIKEN_TEST_ORGANIZATION_NUMBER']);

        $sales = $company->sales();
        $sale = $sales->first();

        $payment = new Payment([
            'date'   => Carbon::now(),
            'amount' => 10000,
        ]);

        $account = $company->accounts(2019)->firstWhere('code', '1920:10001');
        $payment->setAccount($account);

        $saved = $sale->add($payment);

        $this->assertInstanceOf(Payment::class, $saved);
    }

    /*
     * @group dangerous
     */
    // TODO: Getting error from Fiken, perhaps they are not ready yet
/*
    public function test_it_can_add_payment_to_purchase()
    {
        $client = new FikenClient();

        $client->authenticate($_ENV['FIKEN_TEST_USERNAME'], $_ENV['FIKEN_TEST_PASSWORD']);
        $company = $client->setCompany($_ENV['FIKEN_TEST_ORGANIZATION_NUMBER']);

        $purchases = $company->purchases();
        $purchase = $purchases->first();

        $payment = new Payment([
          'date' => Carbon::now(),
          'account' => '1920:10001',
          'amount' => 10000,
        ]);

        $saved = $purchase->add($payment);

        $this->assertInstanceOf(Payment::class, $saved);
    }*/
}
