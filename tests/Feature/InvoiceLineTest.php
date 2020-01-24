<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\Product;
use audunru\FikenClient\Tests\TestCase;
use Illuminate\Support\Facades\App;

class InvoiceLineTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_invoice_line_has_product()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $invoices = $company->invoices();
        $invoice = $invoices->first();
        $lines = $invoice->lines();
        $line = $lines->first();
        $product = $line->product();

        $this->assertInstanceOf(Product::class, $product);
    }
}
