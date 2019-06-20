<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\FikenInvoiceLine;
use audunru\FikenClient\Tests\TestCase;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;

class FikenInvoiceLineTest extends TestCase
{
    use ArraySubsetAsserts;

    public function test_it_creates_an_invoice_line()
    {
        $invoiceLine = new FikenInvoiceLine([
            'netAmount'=> 8000,
            'vatAmount'=> 2000,
            'grossAmount'=> 10000,
            'description'=> 'Latex',
            'comment'=> 'It was supposed to be the summer of George!',
            'vatType'=> 'HIGH',
            'notFillable' => 'The thing that should not be',
        ]);

        $this->assertInstanceOf(
            FikenInvoiceLine::class,
            $invoiceLine
        );
        $this->assertEquals(
            8000,
            $invoiceLine->netAmount
        );
        $this->assertEquals(
            2000,
            $invoiceLine->vatAmount
        );
        $this->assertEquals(
            10000,
            $invoiceLine->grossAmount
        );
        $this->assertEquals(
            'Latex',
            $invoiceLine->description
        );
        $this->assertEquals(
            'It was supposed to be the summer of George!',
            $invoiceLine->comment
        );
        $this->assertEquals(
            'HIGH',
            $invoiceLine->vatType
        );
        $this->assertNull(
            $invoiceLine->notFillable
        );
    }

    public function test_it_checks_the_contents_of_the_new_resource_array()
    {
        $invoiceLine = new FikenInvoiceLine([
            'netAmount'=> 8000,
            'vatAmount'=> 2000,
            'grossAmount'=> 10000,
            'description'=> 'Latex',
            'comment'=> 'It was supposed to be the summer of George!',
            'vatType'=> 'HIGH',
        ]);

        $subset = [
            'netAmount' => 8000,
            'vatAmount' => 2000,
            'grossAmount' => 10000,
            'description' => 'Latex',
            'comment' => 'It was supposed to be the summer of George!',
            'vatType' => 'HIGH',
            'productUrl' => null,
            'incomeAccount' =>  null,
        ];

        $this->assertArraySubset($subset, $invoiceLine->toNewResourceArray());
    }
}
