<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\FikenContact;
use audunru\FikenClient\Models\FikenInvoice;
use audunru\FikenClient\Models\FikenInvoiceLine;
use audunru\FikenClient\Models\FikenSale;
use audunru\FikenClient\Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class FikenInvoiceTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_retrieve_invoices()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $invoices = $company->invoices();
        $invoice = $invoices->first();

        $this->assertInstanceOf(Collection::class, $invoices);
        $this->assertInstanceOf(FikenInvoice::class, $invoice);
    }

    /**
     * @group dangerous
     */
    public function test_it_can_create_an_invoice()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $invoice = new FikenInvoice([
            'issueDate' => Carbon::now(),
            'dueDate' => Carbon::now(),
            'invoiceText' => 'Payment for import/export services', ]
        );
        $customer = $company->contacts()->first();
        $bankAccount = $company->bankAccounts()->first();

        $invoice
          ->setCustomer($customer)
          ->setBankAccount($bankAccount);

        $product = $company->products()->firstWhere('vatType', 'HIGH');
        $line = new FikenInvoiceLine([
            'netAmount' => 8000,
            'vatAmount' => 2000,
            'grossAmount' => 10000,
            'comment' => 'Chips',
        ]);
        $line->setProduct($product);
        $invoice->add($line);

        $saved = $company->add($invoice);

        $this->assertInstanceOf(FikenInvoice::class, $saved);
        $this->assertEquals('Payment for import/export services', $saved->invoiceText);
        $this->assertEquals(8000, $saved->netInNok);
        $this->assertEquals(2000, $saved->vatInNok);
        $this->assertEquals(10000, $saved->grossInNok);
    }

    /**
     * @group dangerous
     */
    public function test_invoice_has_sale()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $invoices = $company->invoices();
        $invoice = $invoices->first();
        $sale = $invoice->sale();

        $this->assertInstanceOf(FikenSale::class, $sale);
    }

    /**
     * @group dangerous
     */
    public function test_invoice_has_customer()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $invoices = $company->invoices();
        $invoice = $invoices->first();
        $customer = $invoice->customer();

        $this->assertInstanceOf(FikenContact::class, $customer);
    }

    /**
     * @group dangerous
     */
    public function test_invoice_has_lines()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $invoices = $company->invoices();
        $invoice = $invoices->first();
        $lines = $invoice->lines();
        $line = $lines->first();

        $this->assertInstanceOf(Collection::class, $lines);
        $this->assertInstanceOf(FikenInvoiceLine::class, $line);
    }
}
