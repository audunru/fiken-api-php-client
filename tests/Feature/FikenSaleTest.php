<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\FikenAttachment;
use audunru\FikenClient\Models\FikenContact;
use audunru\FikenClient\Models\FikenOrderLine;
use audunru\FikenClient\Models\FikenPayment;
use audunru\FikenClient\Models\FikenSale;
use audunru\FikenClient\Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class FikenSaleTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_create_a_sale()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $sale = new FikenSale([
          'date' => Carbon::now(),
          'paymentDate' => Carbon::now(),
          'kind' => 'CASH_SALE',
          'identifier' => '12345',
        ]);

        $paymentAccount = $company->accounts(2019)->firstWhere('code', '1920:10001');
        $sale->setPaymentAccount($paymentAccount);

        $line = new FikenOrderLine([
            'netPrice' => 8000,
            'vat' => 2000,
            'vatType' => 'HIGH',
            'description' => 'Chips',
        ]);
        $sale->add($line);

        $saved = $company->add($sale);

        $this->assertInstanceOf(FikenSale::class, $saved);
    }

    /**
     * @group dangerous
     */
    public function test_it_can_retrieve_sales()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $sales = $company->sales();
        $sale = $sales->first();

        $this->assertInstanceOf(Collection::class, $sales);
        $this->assertInstanceOf(FikenSale::class, $sale);
    }

    /**
     * @group dangerous
     */
    public function test_sale_has_payments()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $sales = $company->sales();
        $sale = $sales->first();
        $payments = $sale->payments();
        $payment = $payments->first();

        $this->assertInstanceOf(Collection::class, $payments);
        $this->assertInstanceOf(FikenPayment::class, $payment);
    }

    /**
     * @group dangerous
     */
    public function test_sale_has_attachments()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $sales = $company->sales();
        $sale = $sales->first();
        $attachments = $sale->attachments();
        $attachment = $attachments->first();

        $this->assertInstanceOf(Collection::class, $attachments);
        $this->assertInstanceOf(FikenAttachment::class, $attachment);
    }

    /**
     * @group dangerous
     */
    public function test_sale_has_customer()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $sales = $company->sales();
        $sale = $sales->first();
        $customer = $sale->customer();

        $this->assertInstanceOf(FikenContact::class, $customer);
    }
}