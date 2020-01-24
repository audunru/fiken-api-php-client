<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\Attachment;
use audunru\FikenClient\Tests\TestCase;
use Illuminate\Support\Facades\App;
use org\bovigo\vfs\vfsStream;

class AttachmentTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_add_attachment_to_invoice()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $invoices = $company->invoices();
        $invoice = $invoices->first();
        $sale = $invoice->sale();

        $root = vfsStream::setup();
        $file = vfsStream::newFile('test.pdf')->at($root);

        $attachment = new Attachment([
            'path'         => vfsStream::url('root/test.pdf'),
            'filename'     => 'Awesome PDF.pdf',
            'attachToSale' => true,
        ]);

        $saved = $sale->add($attachment);

        $this->assertInstanceOf(Attachment::class, $saved);
    }

    /*
     * @group dangerous
     */
    // TODO: Getting error from Fiken, perhaps they are not ready yet
 /*   public function test_it_can_add_attachment_to_purchase()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $purchases = $company->purchases();
        $purchase = $purchases->first();

        $root = vfsStream::setup();
        $file = vfsStream::newFile('test.pdf')->at($root);

        $attachment = new Attachment([
            'path' => vfsStream::url('root/test.pdf'),
            'filename' => 'Awesome PDF.pdf',
            'attachToPayment' => true,
        ]);

        $saved = $purchase->add($attachment);

        $this->assertInstanceOf(Attachment::class, $saved);
    }*/
}
