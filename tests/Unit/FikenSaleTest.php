<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\FikenSale;
use audunru\FikenClient\Tests\TestCase;

class FikenSaleTest extends TestCase
{
    public function test_it_checks_that_new_resource_does_not_have_link_to_self()
    {
        $sale = new FikenSale();
        $this->assertNull($sale->getLinkToSelf());
    }

    public function test_it_checks_that_new_resource_does_not_have_relationship_link()
    {
        $sale = new FikenSale();
        $this->assertNull($sale->getLinkToRelationship('https://fiken.no/api/v1/rel/some-type-of-resource'));
    }
}
