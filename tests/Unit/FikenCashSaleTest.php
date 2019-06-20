<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\FikenCashSale;
use audunru\FikenClient\Tests\TestCase;
use Carbon\Carbon;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;

class FikenCashSaleTest extends TestCase
{
    use ArraySubsetAsserts;

    public function test_it_creates_a_cash_sale()
    {
        $cashSale = new FikenCashSale([
            'issueDate' => new Carbon('2020-01-01'),
            'dueDate' => new Carbon('2020-01-01'),
            'invoiceText' => 'Payment for import and export services',
            'notFillable' => 'The thing that should not be',
        ]);

        $this->assertInstanceOf(
            FikenCashSale::class,
            $cashSale
        );
        $this->assertEquals(
            '2020-01-01',
            $cashSale->issueDate
        );
        $this->assertTrue(
            $cashSale->cash
        );
        $this->assertEquals(
            '2020-01-01',
            $cashSale->dueDate
        );
        $this->assertEquals(
            'Payment for import and export services',
            $cashSale->invoiceText
        );
        $this->assertNull(
            $cashSale->notFillable
        );
    }

    public function test_it_checks_the_contents_of_the_new_resource_array()
    {
        $cashSale = new FikenCashSale([
            'issueDate' => new Carbon('2020-01-01'),
            'dueDate' => new Carbon('2020-01-01'),
            'invoiceText' => 'Payment for import and export services',
        ]);

        $subset = [
            'issueDate' => '2020-01-01',
            'dueDate' => '2020-01-01',
            'customer' => [
                'url' => null,
            ],
            'bankAccountUrl' => null,
            'invoiceText' => 'Payment for import and export services',
            'lines' => null,
            'cash' => true,
            'paymentAccount' => null,
        ];

        $this->assertArraySubset($subset, $cashSale->toNewResourceArray());
    }

    public function test_it_checks_that_new_resource_does_not_have_link_to_self()
    {
        $cashSale = new FikenCashSale();
        $this->assertNull($cashSale->getLinkToSelf());
    }

    public function test_it_checks_that_new_resource_does_not_have_relationship_link()
    {
        $cashSale = new FikenCashSale();
        $this->assertNull($cashSale->getLinkToRelationship('https://fiken.no/api/v1/rel/some-type-of-resource'));
    }
}
