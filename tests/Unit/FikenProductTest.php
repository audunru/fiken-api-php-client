<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\FikenProduct;
use audunru\FikenClient\Tests\TestCase;

class FikenProductTest extends TestCase
{
    public function test_it_creates_a_product()
    {
        $product = new FikenProduct([
            'name' => 'Chips',
            'unitPrice' => 10000,
            'incomeAccount' => '3000',
            'vatType' => 'HIGH',
            'active' => true,
            'productNumber' => '101',
        ]);

        $this->assertInstanceOf(
            FikenProduct::class,
            $product
        );
        $this->assertEquals(
            'Chips',
            $product->name
        );
        $this->assertEquals(
            10000,
            $product->unitPrice
        );
        $this->assertEquals(
            '3000',
            $product->incomeAccount
        );
        $this->assertEquals(
            'HIGH',
            $product->vatType
        );
        $this->assertTrue(
            $product->active
        );
        $this->assertEquals(
            '101',
            $product->productNumber
        );
    }

    public function test_it_checks_that_new_resource_does_not_have_link_to_self()
    {
        $product = new FikenProduct();
        $this->assertNull($product->getLinkToSelf());
    }

    public function test_it_checks_that_new_resource_does_not_have_relationship_link()
    {
        $product = new FikenProduct();
        $this->assertNull($product->getLinkToRelationship('https://fiken.no/api/v1/rel/some-type-of-resource'));
    }
}
