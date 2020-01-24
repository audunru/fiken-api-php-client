<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\Models\Payment;
use audunru\FikenClient\Models\Purchase;
use audunru\FikenClient\Tests\ClientTestCase;
use Illuminate\Support\Collection;

class PurchaseTest extends ClientTestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_retrieve_purchases()
    {
        $purchases = $this->company->purchases();
        $purchase = $purchases->first();

        $this->assertInstanceOf(Collection::class, $purchases);
        $this->assertInstanceOf(Purchase::class, $purchase);
    }

    /**
     * @group dangerous
     */
    public function test_purchase_has_payments()
    {
        $purchases = $this->company->purchases();
        $purchase = $purchases->first();
        $payments = $purchase->payments();
        $payment = $payments->first();

        $this->assertInstanceOf(Collection::class, $payments);
        $this->assertInstanceOf(Payment::class, $payment);
    }
}
