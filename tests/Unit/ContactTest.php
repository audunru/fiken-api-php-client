<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\Contact;
use audunru\FikenClient\Tests\TestCase;

class ContactTest extends TestCase
{
    public function test_it_creates_a_contact()
    {
        $contact = new Contact([
            'name'                   => 'Art Vandelay',
            'email'                  => 'art@vandelayindustries.com',
            'organizationIdentifier' => '123987123',
            'phoneNumber'            => '+47 900 90 123',
            'customer'               => true,
            'supplier'               => true,
            'currency'               => 'NOK',
            'memberNumber'           => 10000,
            'language'               => 'NORWEGIAN',
            'notFillable'            => 'The thing that should not be',
        ]);

        $this->assertInstanceOf(
            Contact::class,
            $contact
        );
        $this->assertEquals(
            'Art Vandelay',
            $contact->name
        );
        $this->assertEquals(
            'art@vandelayindustries.com',
            $contact->email
        );
        $this->assertEquals(
            '123987123',
            $contact->organizationIdentifier
        );
        $this->assertEquals(
            '+47 900 90 123',
            $contact->phoneNumber
        );
        $this->assertTrue(
            $contact->customer
        );
        $this->assertTrue(
            $contact->supplier
        );
        $this->assertEquals(
            'NOK',
            $contact->currency
        );
        $this->assertEquals(
            10000,
            $contact->memberNumber
        );
        $this->assertEquals(
            'NORWEGIAN',
            $contact->language
        );
        $this->assertNull(
            $contact->notFillable
        );
    }

    public function test_it_checks_that_new_resource_does_not_have_link_to_self()
    {
        $contact = new Contact();
        $this->assertNull($contact->getLinkToSelf());
    }

    public function test_it_checks_that_new_resource_does_not_have_relation_link()
    {
        $contact = new Contact();
        $this->assertNull($contact->getLinkToRelation('https://fiken.no/api/v1/rel/some-type-of-resource'));
    }
}
