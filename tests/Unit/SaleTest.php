<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\Sale;
use audunru\FikenClient\Tests\TestCase;

class SaleTest extends TestCase
{
    public function test_it_checks_that_new_resource_does_not_have_link_to_self()
    {
        $sale = new Sale();
        $this->assertNull($sale->getLinkToSelf());
    }

    public function test_it_checks_that_new_resource_does_not_have_relation_link()
    {
        $sale = new Sale();
        $this->assertNull($sale->getLinkToRelation('https://fiken.no/api/v1/rel/some-type-of-resource'));
    }
}
