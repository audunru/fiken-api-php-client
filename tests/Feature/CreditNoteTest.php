<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\Contact;
use audunru\FikenClient\Models\CreditNote;
use audunru\FikenClient\Models\Invoice;
use audunru\FikenClient\Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class CreditNoteTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_retrieve_credit_notes()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $creditNotes = $company->creditNotes();
        $creditNote = $creditNotes->first();

        $this->assertInstanceOf(Collection::class, $creditNotes);
        $this->assertInstanceOf(CreditNote::class, $creditNote);
    }

    /**
     * @group dangerous
     */
    public function test_credit_note_has_customer()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $creditNotes = $company->creditNotes();
        $creditNote = $creditNotes->first();
        $customer = $creditNote->customer();

        $this->assertInstanceOf(Contact::class, $customer);
    }

    /**
     * @group dangerous
     */
    public function test_credit_note_has_invoice()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $creditNotes = $company->creditNotes();
        $creditNote = $creditNotes->first();
        $invoice = $creditNote->invoice();

        $this->assertInstanceOf(Invoice::class, $invoice);
    }
}
