<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\Sale;
use audunru\FikenClient\Tests\TestCase;

class SaleTest extends TestCase
{
    public function testItChecksThatNewResourceDoesNotHaveLinkToSelf()
    {
        $sale = new Sale();
        $this->assertNull($sale->getLinkToSelf());
    }

    public function testItChecksThatNewResourceDoesNotHaveRelationLink()
    {
        $sale = new Sale();
        $this->assertNull($sale->getLinkToRelation('https://fiken.no/api/v1/rel/some-type-of-resource'));
    }
}
