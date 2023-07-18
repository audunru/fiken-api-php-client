<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\Models\Contact;
use audunru\FikenClient\Models\CreditNote;
use audunru\FikenClient\Models\Invoice;
use audunru\FikenClient\Tests\ClientTestCase;
use Illuminate\Support\Collection;

class CreditNoteTest extends ClientTestCase
{
    /**
     * @group dangerous
     */
    public function testItCanRetrieveCreditNotes()
    {
        $creditNotes = $this->company->creditNotes();
        $creditNote = $creditNotes->first();

        $this->assertInstanceOf(Collection::class, $creditNotes);
        $this->assertInstanceOf(CreditNote::class, $creditNote);
    }

    /**
     * @group dangerous
     */
    public function testCreditNoteHasCustomer()
    {
        $creditNotes = $this->company->creditNotes();
        $creditNote = $creditNotes->first();
        $customer = $creditNote->customer();

        $this->assertInstanceOf(Contact::class, $customer);
    }

    /**
     * @group dangerous
     */
    public function testCreditNoteHasInvoice()
    {
        $creditNotes = $this->company->creditNotes();
        $creditNote = $creditNotes->first();
        $invoice = $creditNote->invoice();

        $this->assertInstanceOf(Invoice::class, $invoice);
    }
}
