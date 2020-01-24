<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\Models\Attachment;
use audunru\FikenClient\Tests\ClientTestCase;
use org\bovigo\vfs\vfsStream;

class AttachmentTest extends ClientTestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_add_attachment_to_invoice()
    {
        $invoices = $this->company->invoices();
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
}
