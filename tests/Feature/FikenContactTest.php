<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\FikenContact;
use audunru\FikenClient\Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class FikenContactTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_retrieve_contacts()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $contacts = $company->contacts();
        $contact = $contacts->first();

        $this->assertInstanceOf(Collection::class, $contacts);
        $this->assertInstanceOf(FikenContact::class, $contact);
    }

    /**
     * @group dangerous
     */
    public function test_it_can_create_a_customer()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $contact = new FikenContact([
          'name' => 'Art Vandelay',
          'customer' => true, ]);
        $saved = $company->add($contact);

        $this->assertInstanceOf(FikenContact::class, $saved);
        $this->assertEquals('Art Vandelay', $contact->name);
    }

    /**
     * @group dangerous
     */
    public function test_it_can_update_a_contact()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $contact = $company->contacts()->first();

        $contact->name = 'Duffman';

        $updated = $contact->save();

        $this->assertEquals('Duffman', $updated->name);
    }
}
