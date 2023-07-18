<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\Models\Product;
use audunru\FikenClient\Tests\ClientTestCase;

class InvoiceLineTest extends ClientTestCase
{
    /**
     * @group dangerous
     */
    public function testInvoiceLineHasProduct()
    {
        $invoices = $this->company->invoices();
        $invoice = $invoices->first();
        $lines = $invoice->lines();
        $line = $lines->first();
        $product = $line->product();

        $this->assertInstanceOf(Product::class, $product);
    }
}
