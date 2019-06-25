<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\FikenPurchase;
use audunru\FikenClient\Tests\TestCase;

class FikenPurchaseTest extends TestCase
{
    public function test_it_creates_a_product()
    {
        $purchase = new FikenPurchase([
            'notFillable' => 'The thing that should not be',
        ]);

        $this->assertNull(
            $purchase->notFillable
        );
    }

    public function test_it_checks_that_new_resource_does_not_have_link_to_self()
    {
        $purchase = new FikenPurchase();
        $this->assertNull($purchase->getLinkToSelf());
    }

    public function test_it_checks_that_new_resource_does_not_have_relation_link()
    {
        $purchase = new FikenPurchase();
        $this->assertNull($purchase->getLinkToRelation('https://fiken.no/api/v1/rel/some-type-of-resource'));
    }
}
