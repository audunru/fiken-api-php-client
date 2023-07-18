<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\CashSale;
use audunru\FikenClient\Tests\TestCase;
use Carbon\Carbon;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;

class CashSaleTest extends TestCase
{
    use ArraySubsetAsserts;

    public function testItCreatesACashSale()
    {
        $cashSale = new CashSale([
            'issueDate'   => new Carbon('2020-01-01'),
            'dueDate'     => new Carbon('2020-01-01'),
            'invoiceText' => 'Payment for import and export services',
            'notFillable' => 'The thing that should not be',
        ]);

        $this->assertInstanceOf(
            CashSale::class,
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

    public function testItChecksTheContentsOfTheNewResourceArray()
    {
        $cashSale = new CashSale([
            'issueDate'   => new Carbon('2020-01-01'),
            'dueDate'     => new Carbon('2020-01-01'),
            'invoiceText' => 'Payment for import and export services',
        ]);

        $subset = [
            'issueDate' => '2020-01-01',
            'dueDate'   => '2020-01-01',
            'customer'  => [
                'url' => null,
            ],
            'bankAccountUrl' => null,
            'invoiceText'    => 'Payment for import and export services',
            'lines'          => null,
            'cash'           => true,
            'paymentAccount' => null,
        ];

        $this->assertArraySubset($subset, $cashSale->toNewResourceArray());
    }

    public function testItChecksThatNewResourceDoesNotHaveLinkToSelf()
    {
        $cashSale = new CashSale();
        $this->assertNull($cashSale->getLinkToSelf());
    }

    public function testItChecksThatNewResourceDoesNotHaveRelationLink()
    {
        $cashSale = new CashSale();
        $this->assertNull($cashSale->getLinkToRelation('https://fiken.no/api/v1/rel/some-type-of-resource'));
    }
}
