<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\FikenPayment;
use audunru\FikenClient\Tests\TestCase;
use Carbon\Carbon;

class FikenPaymentTest extends TestCase
{
    public function test_it_creates_a_payment()
    {
        $payment = new FikenPayment([
          'date' => new Carbon('2020-01-01'),
          'amount' => 10000,
          'notFillable' => 'The thing that should not be',
        ]);

        $this->assertInstanceOf(
            FikenPayment::class,
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
        $payment = new FikenPayment();
        $this->assertNull($payment->getLinkToSelf());
    }

    public function test_it_checks_that_new_resource_does_not_have_relationship_link()
    {
        $payment = new FikenPayment();
        $this->assertNull($payment->getLinkToRelationship('https://fiken.no/api/v1/rel/some-type-of-resource'));
    }
}
