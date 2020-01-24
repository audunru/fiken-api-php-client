<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\Models\Contact;
use audunru\FikenClient\Tests\ClientTestCase;
use Illuminate\Support\Collection;

class ContactTest extends ClientTestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_retrieve_contacts()
    {
        $contacts = $this->company->contacts();
        $contact = $contacts->first();

        $this->assertInstanceOf(Collection::class, $contacts);
        $this->assertInstanceOf(Contact::class, $contact);
    }

    /**
     * @group dangerous
     */
    public function test_it_can_create_a_customer()
    {
        $contact = new Contact([
            'name'     => 'Art Vandelay',
            'customer' => true, ]);
        $saved = $this->company->add($contact);

        $this->assertInstanceOf(Contact::class, $saved);
        $this->assertEquals('Art Vandelay', $contact->name);
    }

    /**
     * @group dangerous
     */
    public function test_it_can_update_a_contact()
    {
        $contact = $this->company->contacts()->first();

        $contact->name = 'Duffman';

        $updated = $contact->save();

        $this->assertEquals('Duffman', $updated->name);
    }
}
