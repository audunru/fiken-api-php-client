<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\Payment;
use audunru\FikenClient\Tests\TestCase;
use Carbon\Carbon;

class PaymentTest extends TestCase
{
    public function test_it_creates_a_payment()
    {
        $payment = new Payment([
          'date' => new Carbon('2020-01-01'),
          'amount' => 10000,
          'notFillable' => 'The thing that should not be',
        ]);

        $this->assertInstanceOf(
            Payment::class,
            $payment
        );
        $this->assertEquals(
            '2020-01-01',
            $payment->date
        );
        $this->assertEquals(
            10000,
            $payment->amount
        );
        $this->assertNull(
            $payment->notFillable
        );
    }

    public function test_it_checks_that_new_resource_does_not_have_link_to_self()
    {
        $payment = new Payment();
        $this->assertNull($payment->getLinkToSelf());
    }

    public function test_it_checks_that_new_resource_does_not_have_relation_link()
    {
        $payment = new Payment();
        $this->assertNull($payment->getLinkToRelation('https://fiken.no/api/v1/rel/some-type-of-resource'));
    }
}
