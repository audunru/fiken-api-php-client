<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\Contact;
use audunru\FikenClient\Tests\TestCase;
use Illuminate\Support\Collection;

class ContactTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_retrieve_contacts()
    {
        $client = new FikenClient();

        $client->authenticate($_ENV['FIKEN_TEST_USERNAME'], $_ENV['FIKEN_TEST_PASSWORD']);
        $company = $client->setCompany($_ENV['FIKEN_TEST_ORGANIZATION_NUMBER']);

        $contacts = $company->contacts();
        $contact = $contacts->first();

        $this->assertInstanceOf(Collection::class, $contacts);
        $this->assertInstanceOf(Contact::class, $contact);
    }

    /**
     * @group dangerous
     */
    public function test_it_can_create_a_customer()
    {
        $client = new FikenClient();

        $client->authenticate($_ENV['FIKEN_TEST_USERNAME'], $_ENV['FIKEN_TEST_PASSWORD']);
        $company = $client->setCompany($_ENV['FIKEN_TEST_ORGANIZATION_NUMBER']);

        $contact = new Contact([
            'name'     => 'Art Vandelay',
            'customer' => true, ]);
        $saved = $company->add($contact);

        $this->assertInstanceOf(Contact::class, $saved);
        $this->assertEquals('Art Vandelay', $contact->name);
    }

    /**
     * @group dangerous
     */
    public function test_it_can_update_a_contact()
    {
        $client = new FikenClient();

        $client->authenticate($_ENV['FIKEN_TEST_USERNAME'], $_ENV['FIKEN_TEST_PASSWORD']);
        $company = $client->setCompany($_ENV['FIKEN_TEST_ORGANIZATION_NUMBER']);

        $contact = $company->contacts()->first();

        $contact->name = 'Duffman';

        $updated = $contact->save();

        $this->assertEquals('Duffman', $updated->name);
    }
}
