<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\Models\Payment;
use audunru\FikenClient\Tests\ClientTestCase;
use Carbon\Carbon;

class PaymentTest extends ClientTestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_add_payment_to_sale()
    {
        $sales = $this->company->sales();
        $sale = $sales->first();

        $payment = new Payment([
            'date'   => Carbon::now(),
            'amount' => 10000,
        ]);

        $account = $this->company->accounts(2019)->firstWhere('code', '1920:10001');
        $payment->setAccount($account);

        $saved = $sale->add($payment);

        $this->assertInstanceOf(Payment::class, $saved);
    }
}
