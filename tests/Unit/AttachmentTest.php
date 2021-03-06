<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\Attachment;
use audunru\FikenClient\Tests\TestCase;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use org\bovigo\vfs\vfsStream;

class AttachmentTest extends TestCase
{
    use ArraySubsetAsserts;

    public function test_it_creates_an_attachment()
    {
        $root = vfsStream::setup();
        $file = vfsStream::newFile('test.pdf')->at($root);

        $attachment = new Attachment([
            'path'            => vfsStream::url('root/test.pdf'),
            'filename'        => 'Awesome PDF.pdf',
            'comment'         => 'These pretzels are making me thirsty',
            'attachToPayment' => true,
            'attachToSale'    => true,
            'notFillable'     => 'The thing that should not be',
        ]);

        $this->assertInstanceOf(
            Attachment::class,
            $attachment
        );
        $this->assertEquals(
            vfsStream::url('root/test.pdf'),
            $attachment->path
        );
        $this->assertEquals(
            'Awesome PDF.pdf',
            $attachment->filename
        );
        $this->assertEquals(
            'These pretzels are making me thirsty',
            $attachment->comment
        );
        $this->assertTrue(
            $attachment->attachToPayment
        );
        $this->assertTrue(
            $attachment->attachToSale
        );
        $this->assertNull(
            $attachment->notFillable
        );
    }

    public function test_it_checks_the_contents_of_the_new_resource_array()
    {
        $root = vfsStream::setup();
        $file = vfsStream::newFile('test.pdf')->at($root);

        $attachment = new Attachment([
            'path'            => vfsStream::url('root/test.pdf'),
            'filename'        => 'Awesome PDF.pdf',
            'comment'         => 'These pretzels are making me thirsty',
            'attachToPayment' => true,
            'attachToSale'    => true,
        ]);

        $subset = [
            [
                'name'     => 'AttachmentFile',
                'filename' => 'Awesome PDF.pdf',
            ],
            [
                'name'     => 'SaleAttachment',
                'contents' => '{"filename":"Awesome PDF.pdf","comment":"These pretzels are making me thirsty","attachToPayment":true,"attachToSale":true}',
            ],
        ];

        $this->assertArraySubset($subset, $attachment->toNewResourceArray());
    }

    public function test_it_checks_that_new_resource_does_not_have_link_to_self()
    {
        $attachment = new Attachment();
        $this->assertNull($attachment->getLinkToSelf());
    }

    public function test_it_checks_that_new_resource_does_not_have_relation_link()
    {
        $attachment = new Attachment();
        $this->assertNull($attachment->getLinkToRelation('https://fiken.no/api/v1/rel/some-type-of-resource'));
    }
}
