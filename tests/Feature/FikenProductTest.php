<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\FikenProduct;
use audunru\FikenClient\Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class FikenProductTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_retrieve_products()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $products = $company->products();
        $product = $products->first();

        $this->assertInstanceOf(Collection::class, $products);
        $this->assertInstanceOf(FikenProduct::class, $product);
    }

    /**
     * @group dangerous
     */
    public function test_it_can_create_a_product()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $product = new FikenProduct([
          'name' => 'Latex',
          'incomeAccount' => 3000,
          'vatType' => 'HIGH',
          'active' => true, ]);
        $saved = $company->add($product);

        $this->assertInstanceOf(FikenProduct::class, $saved);
        $this->assertEquals('Latex', $product->name);
        $this->assertEquals(3000, $product->incomeAccount);
        $this->assertEquals('HIGH', $product->vatType);
        $this->assertTrue($product->active);
    }

    /**
     * @group dangerous
     */
    public function test_it_can_update_a_product()
    {
        $client = App::make(FikenClient::class);

        $client->authenticate(env('FIKEN_TEST_USERNAME'), env('FIKEN_TEST_PASSWORD'));
        $company = $client->setCompany(env('FIKEN_TEST_ORGANIZATION_NUMBER'));

        $product = $company->products()->first();

        $product->name = 'Chips';

        $updated = $product->save();

        $this->assertNull($updated);
    }
}
