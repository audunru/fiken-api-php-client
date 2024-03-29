<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\Models\Attachment;
use audunru\FikenClient\Models\Contact;
use audunru\FikenClient\Models\OrderLine;
use audunru\FikenClient\Models\Payment;
use audunru\FikenClient\Models\Sale;
use audunru\FikenClient\Tests\ClientTestCase;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SaleTest extends ClientTestCase
{
    /**
     * @group dangerous
     */
    public function testItCanCreateASale()
    {
        $sale = new Sale([
            'date'        => Carbon::now(),
            'paymentDate' => Carbon::now(),
            'kind'        => 'CASH_SALE',
            'identifier'  => '12345',
        ]);

        $paymentAccount = $this->company->accounts(2019)->firstWhere('code', '1920:10001');
        $sale->setPaymentAccount($paymentAccount);

        $line = new OrderLine([
            'netPrice'    => 8000,
            'vat'         => 2000,
            'vatType'     => 'HIGH',
            'description' => 'Chips',
        ]);
        $sale->add($line);

        $saved = $this->company->add($sale);

        $this->assertInstanceOf(Sale::class, $saved);
    }

    /**
     * @group dangerous
     */
    public function testItCanRetrieveSales()
    {
        $sales = $this->company->sales();
        $sale = $sales->first();

        $this->assertInstanceOf(Collection::class, $sales);
        $this->assertInstanceOf(Sale::class, $sale);
    }

    /**
     * @group dangerous
     */
    public function testSaleHasPayments()
    {
        $sales = $this->company->sales();
        $sale = $sales->where('kind', 'INVOICE')->where('paid', true)->first();
        $payments = $sale->payments();
        $payment = $payments->first();

        $this->assertInstanceOf(Collection::class, $payments);
        $this->assertInstanceOf(Payment::class, $payment);
    }

    /**
     * @group dangerous
     */
    public function testSaleHasAttachments()
    {
        $sales = $this->company->sales();
        $sale = $sales->where('kind', 'INVOICE')->first();
        $attachments = $sale->attachments();
        $attachment = $attachments->first();

        $this->assertInstanceOf(Collection::class, $attachments);
        $this->assertInstanceOf(Attachment::class, $attachment);
    }

    /**
     * @group dangerous
     */
    public function testSaleHasCustomer()
    {
        $sales = $this->company->sales();
        $sale = $sales->where('kind', 'INVOICE')->first();
        $customer = $sale->customer();

        $this->assertInstanceOf(Contact::class, $customer);
    }
}
