<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\OrderLine;
use audunru\FikenClient\Tests\TestCase;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;

class OrderLineTest extends TestCase
{
    use ArraySubsetAsserts;

    public function testItCreatesAnOrderLine()
    {
        $orderLine = new OrderLine([
            'description'       => 'These pretzels are making me thirsty',
            'netPrice'          => 8000,
            'vat'               => 2000,
            'vatType'           => 'HIGH',
            'netPriceInCurrency'=> 321,
            'vatInCurrency'     => 123,
        ]);

        $this->assertInstanceOf(
            OrderLine::class,
            $orderLine
        );
        $this->assertEquals(
            'These pretzels are making me thirsty',
            $orderLine->description
        );
        $this->assertEquals(
            8000,
            $orderLine->netPrice
        );
        $this->assertEquals(
            2000,
            $orderLine->vat
        );
        $this->assertEquals(
            'HIGH',
            $orderLine->vatType
        );
        $this->assertEquals(
            321,
            $orderLine->netPriceInCurrency
        );
        $this->assertEquals(
            123,
            $orderLine->vatInCurrency
        );
        $this->assertNull(
            $orderLine->notFillable
        );
    }

    public function testItChecksTheContentsOfTheNewResourceArray()
    {
        $orderLine = new OrderLine([
            'description'       => 'These pretzels are making me thirsty',
            'netPrice'          => 8000,
            'vat'               => 2000,
            'vatType'           => 'HIGH',
            'netPriceInCurrency'=> 321,
            'vatInCurrency'     => 123,
        ]);

        $subset = [
            'description'       => 'These pretzels are making me thirsty',
            'netPrice'          => 8000,
            'vat'               => 2000,
            'account'           => null,
            'vatType'           => 'HIGH',
            'netPriceInCurrency'=> 321,
            'vatInCurrency'     => 123,
        ];

        $this->assertArraySubset($subset, $orderLine->toNewResourceArray());
    }
}
