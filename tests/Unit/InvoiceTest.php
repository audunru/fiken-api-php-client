<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\Invoice;
use audunru\FikenClient\Tests\TestCase;
use Carbon\Carbon;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;

class InvoiceTest extends TestCase
{
    use ArraySubsetAsserts;

    public function testItCreatesAInvoice()
    {
        $invoice = new Invoice([
            'issueDate'   => new Carbon('2020-01-01'),
            'dueDate'     => new Carbon('2020-01-15'),
            'invoiceText' => 'Payment for import and export services',
            'notFillable' => 'The thing that should not be',
        ]);

        $this->assertInstanceOf(
            Invoice::class,
            $invoice
        );
        $this->assertEquals(
            '2020-01-01',
            $invoice->issueDate
        );
        $this->assertEquals(
            '2020-01-15',
            $invoice->dueDate
        );
        $this->assertEquals(
            'Payment for import and export services',
            $invoice->invoiceText
        );
        $this->assertNull(
            $invoice->notFillable
        );
    }

    public function testItChecksTheContentsOfTheNewResourceArray()
    {
        $invoice = new Invoice([
            'issueDate'   => new Carbon('2020-01-01'),
            'dueDate'     => new Carbon('2020-01-15'),
            'invoiceText' => 'Payment for import and export services',
        ]);

        $subset = [
            'issueDate' => '2020-01-01',
            'dueDate'   => '2020-01-15',
            'customer'  => [
                'url' => null,
            ],
            'bankAccountUrl' => null,
            'invoiceText'    => 'Payment for import and export services',
            'lines'          => null,
        ];

        $this->assertArraySubset($subset, $invoice->toNewResourceArray());
    }

    public function testItChecksThatNewResourceDoesNotHaveLinkToSelf()
    {
        $invoice = new Invoice();
        $this->assertNull($invoice->getLinkToSelf());
    }

    public function testItChecksThatNewResourceDoesNotHaveRelationLink()
    {
        $invoice = new Invoice();
        $this->assertNull($invoice->getLinkToRelation('https://fiken.no/api/v1/rel/some-type-of-resource'));
    }
}
